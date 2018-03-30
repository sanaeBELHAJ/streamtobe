<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;

use App\User;

class UserController extends Controller
{
    protected $nbPerPage = 4;

    public function __construct(){

    }
    
    /**
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
		$users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Display the specified resource
     * 
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function show($pseudo){
        $user = User::wherePseudo($pseudo)->first();
        if(!$user)
            abort(404);
        return view('user.show', compact('user'));
    }
    
}
