<?php

namespace App\Http\Controllers;

use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\http\Response
     */
    public function updateInfos(Request $request){
        $user = Auth::user();    
        
        if(!$request->filled(['password', 'password_confirmation'])){
            $request->offsetUnset('password');
            $request->offsetUnset('password_confirmation');
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
		return back();
    }
}
