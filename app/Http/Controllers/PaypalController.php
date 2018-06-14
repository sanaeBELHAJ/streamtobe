<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Invoice;
use App\Viewer;
use App\User;
use App\Stream;
use URL;

class PaypalController extends Controller
{
    protected $provider;
    protected $url_referer;

    public function __construct() {
        $this->middleware('auth');
        $this->provider = new ExpressCheckout();
        $this->url_referer = URL::previous();
    }
    
    public function expressCheckout(Request $request) {
        // check if payment is recurring
        $recurring = $request->input('recurring', false) ? true : false;
      
        // get new invoice id
        $invoice_id = Invoice::count() + 1;
            
        // Get the cart data
        $cart = $this->getCart($recurring, $invoice_id);
      
        // create new invoice
        $invoice = new Invoice();
        $invoice->title = $cart['invoice_description'];
        $invoice->price = $cart['total'];
        $invoice->viewer_id = $this->getViewerId($request->input('stream'));
        $invoice->save();
      
        // send a request to paypal 
        // paypal should respond with an array of data
        // the array should contain a link to paypal's payment system
        $response = $this->provider->setExpressCheckout($cart, $recurring);
        
        // if there is no link redirect back with error message
        if (!$response['paypal_link']) {
            dd($response);
            return redirect($this->url_referer)
                        ->with([
                            'code' => 'danger', 
                            'message' => 'Something went wrong with PayPal'
                        ]);
            // For the actual error message dump out $response and see what's in there
        }
      
        // redirect to paypal
        // after payment is done paypal will redirect us back to $this->expressCheckoutSuccess
        return redirect($response['paypal_link']);
    }

    private function getCart($recurring, $invoice_id) {
        if ($recurring) {
            return [
                // if payment is recurring cart needs only one item
                // with name, price and quantity
                'items' => [
                    [
                        'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                        'price' => 20,
                        'qty' => 1,
                    ],
                ],

                // return url is the url where PayPal returns after user confirmed the payment
                'return_url' => url('/paypal/express-checkout-success?recurring=1'),
                'subscription_desc' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                // every invoice id must be unique, else you'll get an error from paypal
                'invoice_id' => config('paypal.invoice_prefix') . '_' . $invoice_id,
                'invoice_description' => "Order #". $invoice_id ." Invoice",
                'cancel_url' => $this->url_referer,
                // total is calculated by multiplying price with quantity of all cart items and then adding them up
                // in this case total is 20 because price is 20 and quantity is 1
                'total' => 20, // Total price of the cart
            ];
        }

        return [
            // if payment is not recurring cart can have many items
            // with name, price and quantity
            'items' => [
                [
                    'name' => 'Product 1',
                    'price' => 10,
                    'qty' => 1,
                ],
                /*[
                    'name' => 'Product 2',
                    'price' => 5,
                    'qty' => 5,
                ],*/
            ],
            'total' => 35,
            // return url is the url where PayPal returns after user confirmed the payment
            'return_url' => url('/paypal/express-checkout-success'),
            // every invoice id must be unique, else you'll get an error from paypal
            'invoice_id' => config('paypal.invoice_prefix') . '_' . $invoice_id,
            'invoice_description' => "Order #" . $invoice_id . " Invoice",
            'cancel_url' => $this->url_referer,
        ];
    }

    public function expressCheckoutSuccess(Request $request) {

        // check if payment is recurring
        $recurring = $request->input('recurring', false) ? true : false;

        $token = $request->get('token');

        $PayerID = $request->get('PayerID');

        // initaly we paypal redirects us back with a token
        // but doesn't provice us any additional data
        // so we use getExpressCheckoutDetails($token)
        // to get the payment details
        $response = $this->provider->getExpressCheckoutDetails($token);

        // if response ACK value is not SUCCESS or SUCCESSWITHWARNING
        // we return back with error
        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return redirect($this->url_referer)
                    ->with([
                        'code' => 'danger', 
                        'message' => 'Error processing PayPal payment'
                    ]);
        }

        // invoice id is stored in INVNUM
        // because we set our invoice to be xxxx_id
        // we need to explode the string and get the second element of array
        // witch will be the id of the invoice
        $invoice_id = explode('_', $response['INVNUM'])[1];

        // get cart data
        $cart = $this->getCart($recurring, $invoice_id);

        // check if our payment is recurring
        if ($recurring === true) {
            
            // if recurring then we need to create the subscription
            // you can create monthly or yearly subscriptions
            $response = $this->provider->createMonthlySubscription($response['TOKEN'], $response['AMT'], $cart['subscription_desc']);
            
            $status = 'Invalid';
            // if after creating the subscription paypal responds with activeprofile or pendingprofile
            // we are good to go and we can set the status to Processed, else status stays Invalid
            if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                $status = 'Processed';
            }

        } else {

            // if payment is not recurring just perform transaction on PayPal
            // and get the payment status
            $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

        }

        // find invoice by id
        $invoice = Invoice::find($invoice_id);

        // set invoice status
        $invoice->payment_status = $status;

        // if payment is recurring lets set a recurring id for latter use
        if ($recurring === true) {
            $invoice->recurring_id = $response['PROFILEID'];
        }

        // save the invoice
        $invoice->save();

        // App\Invoice has a paid attribute that returns true or false based on payment status
        // so if paid is false return with error, else return with success message
        if ($invoice->paid) {
            return redirect($this->url_referer)
                    ->with([
                        'code' => 'success',
                        'message' => 'Order ' . $invoice->id . ' has been paid successfully!'
                    ]);
        }
        
        return redirect($this->url_referer)
                ->with([
                    'code' => 'danger',
                    'message' => 'Error processing PayPal payment for Order ' . $invoice->id . '!'
                ]);
    }
    
    private function getViewerId($pseudo){
        $streamer = User::where('pseudo', $pseudo)->first();
        
        $viewer = Viewer::where('user_id', Auth::user()->id)
                        ->where('stream_id', $streamer->stream->id)
                        ->first();
        return $viewer->id;
    }

}
