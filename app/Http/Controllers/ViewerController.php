<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Theme;
use App\Type;
use App\Stream;
use App\Viewer;
use Illuminate\Support\Facades\Auth;

class ViewerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateFollow(Request $request){
        $streamer = User::where('pseudo', '=', $request->get('stream'))->first();
        $viewer = Viewer::where('stream_id', '=', $streamer->stream->id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->first();
        
        $viewer->is_follower = intval($request->get('is_following'));
        $viewer->save();

        return $viewer->is_follower;
    }
}
