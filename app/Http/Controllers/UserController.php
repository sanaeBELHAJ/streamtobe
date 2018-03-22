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
     * Show the form for creating a new resource
     * Affichage des formulaires d'inscription / authentification
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('user.login');
    }

    /**
     * Store a newly created resource in storage
     * Enregistrement d'un nouveau compte en BDD
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request){
        
        $user = $this->userRepository->store($request->all());

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

    /**
     * 
     */
    public function confirmAccount(){
        //
    }

    /**
     * 
     */
    public function login(LoginRequest $request){
        //
    }

    /**
     * 
     */
    public function forgot(ForgotRequest $request){
        //
    }

    /**
     * Display the specified resource
     * 
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function show($pseudo){
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
