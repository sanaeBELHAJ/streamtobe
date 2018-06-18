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

class MessageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the actives streams
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('messages.index');
    }
}
