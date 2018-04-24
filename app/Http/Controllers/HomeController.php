<?php

namespace App\Http\Controllers;

use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Account\UserInfosRequest;

class HomeController extends Controller
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
    public function index()
    {
        $user = Auth::user();
        return view('account.index')->with(compact('user'));
    }

    /**
     * Update the specified account in storage
     * 
     * @param \App\Http\Requests\Account\UserInfosRequest $request
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
            $user->picture = $user->setPathPicture($path);
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
    public function updateStream(Request $request){
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
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        $user = Auth::user();
        $user->activated = 0;
        $user->status = -1;
        $user->save();
		Auth::logout();
        return redirect('/login');
    }    
}
