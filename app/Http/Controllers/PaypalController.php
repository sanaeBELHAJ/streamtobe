<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Invoice;
use App\Viewer;
use App\User;
use App\Stream;
use URL;

class PaypalController extends Controller
{
    protected $url_referer;

    public function __construct() {
        $this->middleware('auth');
        $this->url_referer = URL::previous();
    }
    
    public function validGiveaway(Request $request){
        if(!$request->input('payment'))
            return false;
        
        $payment = $request->input('payment');

        $invoice = Invoice::create([
            "paypal_id"     => $payment['id'],
            "paypal_cart "  => $payment['cart'],
            "amount"        => $payment['transactions'][0]['amount']['total'],
            "currency"      => $payment['transactions'][0]['amount']['currency'],
            "country"       => $payment['payer']['payer_info']['country_code'],
            "city"          => $payment['payer']['payer_info']['shipping_address']['city'],
            "message"       => $payment['message'],
            "paypal_payer_id" => $payment['payer']['payer_info']['payer_id'],
            "viewer_id"     => $this->getViewerId($payment['streamer']),
            "status"        => $payment['state'],
            //"created_at"    => $payment['create_time'],
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
