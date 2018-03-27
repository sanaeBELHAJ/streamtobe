<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;

use App\User;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ForgotRequest;
use App\Http\Requests\User\UpdateRequest;

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
		$links = $users->render();
        return view('user.index', compact('users', 'links'));
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
