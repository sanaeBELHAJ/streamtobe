<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the account form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('account.index', compact('user'));
    }

    /**
     * Show the specified account in storage
     * 
     * @param \Illuminate\http\Request $request
     * @param string $pseudo
     * @return \Illuminate\http\Response
     */
    public function edit(UpdateRequest $request){
        $this->userRepository->update($pseudo, $request->all());
        Session::flash('message', 'La mise à jour des informations a bien été effectuée.');
        Session::flash('alert-class', 'alert-success'); 
        return redirect('user');
    }

    /**
     * Update the specified account in storage
     * 
     * @param \Illuminate\http\Request $request
     * @param string $pseudo
     * @return \Illuminate\http\Response
     */
    public function update(UpdateRequest $request){
        $this->userRepository->update($pseudo, $request->all());
        Session::flash('message', 'La mise à jour des informations a bien été effectuée.');
        Session::flash('alert-class', 'alert-success'); 
        return redirect('user');
    }

    /**
     * Remove the specified account from storage
     * 
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function destroy($pseudo){
        $this->userRepository->destroy($id);
		return back();
    }
}
