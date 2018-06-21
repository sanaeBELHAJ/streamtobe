<?php

namespace App\Http\Controllers;

use Session;
use App\Stream;
use App\Viewer;
use App\Chat;
use App\Invoice;
use App\Subscriber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\UserInfosRequest;

class AccountController extends Controller
{
    public $user;

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
     * Show the account form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $user = Auth::user();
        $stream = $user->stream; //Chaine de l'utilisateur
        $viewers = $stream->viewers; //Followers de l'utilisateur
        $channels = Viewer::where('user_id', $user->id)->get(); //Chaines suivies par l'utilisateur

        //Mes followers
        $subscribers = [];
        foreach($viewers as $viewer)
            $subscribers[] = $viewer->subscribes->where('viewer_id',$viewer->id)->first();

        //Mes dons reçus 
        $donations = [];
        foreach($viewers as $viewer){
            foreach($viewer->donations as $donation)
                $donations[] = $donation;
        }

        //Mes streams favoris 
        $donations = [];
        foreach($channels as $channel){
            foreach($channel->donations as $donation)
                $donations[] = $donation;
        }

        return view('account.index')
                ->with(compact(
                    'user', 
                    'stream', 
                    'viewers', 
                    'subscribers', 
                    'donations', 
                    'channels'
                ));
    }

    /**
     * Update the specified account in storage
     * 
     * @param \App\Http\Requests\UserInfosRequest $request
     * @return \Illuminate\http\Response
     */
    public function updateInfos(UserInfosRequest $request){
        $user = Auth::user();    
        
        //Change password
        if(!$request->filled(['password', 'password_confirmation'])){
            $request->offsetUnset('password');
            $request->offsetUnset('password_confirmation');
        }
        else
            $request->replace(['password' => bcrypt($request->input('password'))]);

        //Change image and store path in database
        if($request->hasFile('pictureAccount')){ 
            $path = $request->file('pictureAccount')->store('public/avatars/'.$user->pseudo);
            $user->avatar = $user->setPathAvatar($path);
        }

        $user->update($request->all());
        $user->save();
        Session::flash('message', 'La mise à jour des informations a bien été effectuée.');
        Session::flash('alert-class', 'alert-success');
        return redirect('home');
    }

    /**
     * Update the specified account in storage
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\http\Response
     */
    public function updateStats(Request $request){
        Session::flash('message', 'La mise à jour des informations a bien été effectuée.');
        Session::flash('alert-class', 'alert-success'); 
        return redirect('home');
    }

    /**
     * Update the specified account in storage
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\http\Response
     */
    public function updateSubscription(Request $request){
        Session::flash('message', 'La mise à jour des informations a bien été effectuée.');
        Session::flash('alert-class', 'alert-success'); 
        return redirect('home');
    }

    /**
     * Remove the specified account from storage
     * Disable the stream channel
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        $user = Auth::user();
        $user->name = null;
        $user->email = null;
        $user->activated = 0;
        $user->status = -2;
        $user->save();

        $stream = Stream::where('streamer_id', $user->id)->firstOrFail();
        $stream->status = 0;
        $stream->title = null;
        $stream->save();
        
        Auth::logout();
        return redirect('/login');
    }   
}
