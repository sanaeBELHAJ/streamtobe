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
    


   

   
    
    private function getViewerId($pseudo){
        $streamer = User::where('pseudo', $pseudo)->first();
        
        $viewer = Viewer::where('user_id', Auth::user()->id)
                        ->where('stream_id', $streamer->stream->id)
                        ->first();
        return $viewer->id;
    }

}
