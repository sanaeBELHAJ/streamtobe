<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\ReportCat;
use App\Report;

class HomeController extends Controller
{
    public function __construct(){
        
    }
    
    /**
     * Valid the cookies use
     * 
     * @return \Illuminate\Http\Response
     */
    public function valid_cookie(){
        if(!isset($_COOKIE['valid_cookie'])) {
            setcookie("valid_cookie", 1, time()+60*60*24*30*12);//Expiration dans 1 an
        }
    }
}
