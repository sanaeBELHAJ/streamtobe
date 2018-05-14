<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Viewer;
use App\ReportCat;
use App\Report;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReportRequest;

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

    /**
     * Edit the following status of the viewer
     */
    public function updateFollow(Request $request){
        $streamer = User::where('pseudo', '=', $request->get('stream'))->first();
        $viewer = Viewer::where('stream_id', '=', $streamer->stream->id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->first();
        
        $viewer->is_follower = intval($request->get('is_following'));
        $viewer->save();

        return $viewer->is_follower;
    }

    /**
     * Report another user
     */
    public function report(ReportRequest $request){
        $streamer = User::where('pseudo', '=', $request->get('streamer'))->first();
        $reportCat = ReportCat::where('name', '=', $request->get('category'))->first();
        
        if($streamer && $reportCat){
            Report::create([
                'category_id'   => $reportCat->id,
                'victim_id'     => Auth::user()->id,
                'guilty_id'     => $streamer->id,
                'description'   => $request->get('description'),
                'status'        => 1
            ]);
            Session::flash('message', 'Votre signalement a correctement été effectué.');
            Session::flash('alert-class', 'alert-success');
        }
        else if(!$streamer){
            Session::flash('message', 'Votre signalement doit préciser un utilisateur.');
            Session::flash('alert-danger');
        }
        else if(!$reportCat){
            Session::flash('message', "Vous devez préciser le type d'incident");
            Session::flash('alert-danger');
        }

        return redirect()->back();
    }
}
