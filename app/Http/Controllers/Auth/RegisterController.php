<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Mail;
use Session;
use App\User;
use App\Stream;
use App\Viewer;
use App\Type;
use App\Countries;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    
    /**
    * Show the application registration form.
    *
    * @return \Illuminate\Http\Response
    */
    public function showRegistrationForm()
    {
       $countries = Countries::all();
       return view('auth.register', compact('countries'));
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pseudo' => 'required|string|max:255|unique:users',
            'countries' => 'in:stb_countries',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create new user and stream instances after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['confirmation_code'] = str_random(30);
        $user = User::create([
                'pseudo'            => $data['pseudo'],
                'email'             => $data['email'],
                'name'              => str_random(10),
                'id_countries'      => $data['country'],
                'password'          => Hash::make($data['password']),
                'confirmation_code' => $data['confirmation_code']
            ]);
        $type = Type::where('name', 'default')->firstOrFail();
        $stream = Stream::create([
            'title' => 'Titre',
            'streamer_id' => $user->id,
            'type_id' => $type->id
        ]);
        
        $viewer = Viewer::create([
            'stream_id' => $stream->id,
            'user_id'   => $user->id,
            'rank'      => 2, //Propriétaire du stream,
            'is_follower' => 1 
        ]);

        return $user;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        /*event(new Registered(*/$user = $this->create($request->all())/*))*/;
        $data = $user->getAttributes();

        Mail::send('auth.confirmation', $data, function($message) use($data) 
        {
            $message->to($data['email'])->subject("Confirmation d'inscription");
        });

        Session::flash('messageRegister', 'Inscription effectuée, un email de confirmation vous a été adressé.');
        Session::flash('alert-class', 'alert-success'); 

        return redirect($this->redirectPath())->with('messageRegister', 'Your message');
    }

    /**
     * Activate the account user
     * 
     * @param $confirmation_code
     * @return \Illuminate\Http\Response
     */
    public function confirmAccount($confirmation_code){

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user){
            return redirect('login');
        }

        $user->activated = 1;
        $user->confirmation_code = null;
        $user->save();

        Session::flash('message', 'Vous avez correctement vérifié votre compte, vous pouvez dès à présent vous logger.');
        Session::flash('alert-class', 'alert-success'); 

        return redirect('login');
    }
}
