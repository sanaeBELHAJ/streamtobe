<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;

use App\User;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotRequest;

class UserController extends Controller
{
    //
    public function index(){
        return view('user.login');
    }

    public function register(RegisterRequest $request){
        
        $user = new User;
        $user->email = $request->input('email');
        $user->save();

        Mail::send('email.confirmation', $request->all(), function($message) use($request) 
        {
            $message->to($request->input('email'))->subject("Confirmation d'inscription");
        });

        Session::flash('message', 'Inscription effectuée, un email de confirmation vous a été adressé.');
        Session::flash('alert-class', 'alert-success'); 
        /*
            Un compte existe déjà à cette adresse.
            Impossible d'envoyer l'email de confirmation.
        */
        return back()->withInput();
    }

    public function confirmAccount(){
        //
    }

    public function login(LoginRequest $request){
        //
    }

    public function forgot(ForgotRequest $request){
        //
    }

    public function editAccount(){
        //
    }

    public function deleteAccount(){
        //
    }

}
