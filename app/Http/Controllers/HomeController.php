<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\User;

use App\Http\Requests\SupportRequest;

class HomeController extends Controller
{
    public function __construct(){
        
    }
    
    /**
     * Valid the cookies use
     * 
     */
    public function valid_cookie(){
        if(!isset($_COOKIE['valid_cookie'])) {
            setcookie("valid_cookie", 1, time()+60*60*24*30*12);//Expiration dans 1 an
        }
    }

    /**
     * Send an email to the staff members
     * 
     */
    public function support(SupportRequest $request){
        $datas = [
            "from" => Auth::user()->email,
            "content" => $request->input('opinion')
        ];
        Mail::send('account.support', $datas, function($message){
            $message->to(env("MAIL_USERNAME"));
            $message->subject("Un utilisateur vous a contacté");
        });
        return response()->json(['ok' => 'ok']);
    }
    
}
