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

use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;
    protected $nbPerPage = 4;

    public function __construct(UserRepository $userRepository){
		$this->userRepository = $userRepository;
    }
    
    /**
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = $this->userRepository->getPaginate($this->nbPerPage);
		$links = $users->render();
        return view('user.index', compact('users', 'links'));
    }

    /**
     * 
     */
    public function confirmAccount($confirmation_code){

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user){
            return redirect('login');
        }

        $user->activated = 1;
        $user->confirmation_code = null;
        $user->save();

        Session::flash('messageVerify', 'Vous avez correctement vérifié votre compte, vous pouvez dès à présent vous logger.');
        Session::flash('alert-class', 'alert-success'); 

        return redirect('login');
    }

    /**
     * Display the specified resource
     * 
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function show($pseudo){
        dd($pseudo);
        //$user = $this->userRepository->getByPseudo($pseudo);
        //return view('user.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource
     * 
     * @param string pseudo
     * @return \Illuminate\Http\Response
     */
    public function edit($pseudo){
        
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
