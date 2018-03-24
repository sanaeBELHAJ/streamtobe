<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show',]]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for editing the specified resource
     * 
     * @param string pseudo
     * @return \Illuminate\Http\Response
     */
    public function showEditForm($pseudo){
        
    }

    /**
     * Update the specified resource in storage
     * 
     * @param \Illuminate\http\Request $request
     * @param string $pseudo
     * @return \Illuminate\http\Response
     */
    public function update(UpdateRequest $request, $pseudo){
        $this->userRepository->update($pseudo, $request->all());
        Session::flash('message', 'La mise à jour des informations a bien été effectuée.');
        Session::flash('alert-class', 'alert-success'); 
        return redirect('user');
    }

    /**
     * Remove the specified resource from storage
     * 
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function destroy($pseudo){
        $this->userRepository->destroy($id);
		return back();
    }
}
