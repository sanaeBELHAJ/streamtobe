<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        return view('user.login');
    }

    public function register(RegisterRequest $request){
        //
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
