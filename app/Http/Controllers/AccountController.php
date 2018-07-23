<?php

namespace App\Http\Controllers;

use Session;
use App\Stream;
use App\Viewer;
use App\Chat;
use App\Invoice;
use App\Subscriber;
use App\Countries;
use App\User;
use App\Theme;
use App\ReportCat;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserInfosRequest;

class AccountController extends Controller {

    public $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the user account form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $streamer = Auth::user();
        $user = Auth::user();
        $countries = Countries::all();
        
        return view('account.index')->with(compact('user', 'streamer', 'countries'));
    }

    /**
     * Display a user account
     * 
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $pseudo) {
        $streamer = User::where('pseudo', $pseudo)
                ->where('status', 1)
                ->first();

        if (!$streamer)
            abort(404);

        $themes = Theme::all();
        $stream = $streamer->stream; //Chaine de l'utilisateur
        $viewers = $stream->viewers; //Followers de l'utilisateur
        $channels = Viewer::where('user_id', $streamer->id)->get(); //Chaines suivies par l'utilisateur
        //Mes dons reçus 
        $donations = [];
        foreach ($viewers as $viewer) {
            foreach ($viewer->donations as $donation)
                $donations[] = $donation;
        }

        return view('account.profil', compact('themes', 'streamer','viewers','channels','donations'));
    }

    /**
     * Show the donations list.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats(Request $request, $pseudo = null) {

        $streamer = ($pseudo != null) ? User::where('pseudo', $pseudo)->where('status', '>', 0)->first() : Auth::user();
        $stream = $streamer->stream; //Chaine de l'utilisateur
        $viewers = $stream->viewers; //Followers de l'utilisateur

        //Mes dons reçus 
        $donations = [];
        foreach ($viewers as $viewer) {
            foreach ($viewer->donations as $donation)
                $donations[] = $donation;
        }

        return view('account.stats')->with(compact('streamer', 'stream', 'viewers', 'donations'));
    }

    /**
     * Show the followers list.
     *
     * @return \Illuminate\Http\Response
     */
    public function fans(Request $request, $pseudo = null) {
        $streamer = ($pseudo != null) ? User::where('pseudo', $pseudo)->where('status', '>', 0)->first() : Auth::user();
        return view('account.fans')->with(compact('streamer'));
    }

    /**
     * Show the users list followed by the streamer.
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function follows(Request $request, $pseudo = null) {
        $streamer = ($pseudo != null) ? User::where('pseudo', $pseudo)->where('status', '>', 0)->first() : Auth::user();
        $stream = $streamer->stream; //Chaine de l'utilisateur
        $viewers = $stream->viewers; //Followers de l'utilisateur
        $channels = Viewer::where('user_id', $streamer->id)->get(); //Chaines suivies par l'utilisateur

        return view('account.follows')->with(compact('streamer', 'stream', 'viewers', 'channels'));
    }

    /**
     * Update the specified account in storage
     * 
     * @param \App\Http\Requests\UserInfosRequest $request
     * @return \Illuminate\http\Response
     */
    public function updateInfos(UserInfosRequest $request) {
        $user = Auth::user();

        //Change password
        if (!$request->filled(['password', 'password_confirmation'])) {
            $request->offsetUnset('password');
            $request->offsetUnset('password_confirmation');
        } else
            $request->replace(['password' => bcrypt($request->input('password'))]);

        //Change image and store path in database
        if ($request->hasFile('pictureAccount')) {
            $path = $request->file('pictureAccount')->store('public/avatars/' . $user->pseudo);
            $user->avatar = $user->setPathAvatar($path);
        }
        $country = Countries::where('id', $request->input('country'))->first();
        if($country)
            $user->id_countries = $country->id;
    
        $user->update($request->all());
        $user->save();
        Session::flash('message', 'La mise à jour des informations a bien été effectuée.');
        Session::flash('alert-class', 'alert-success');
        return redirect('home');
    }

    /**
     * Remove the specified account from storage
     * Disable the stream channel
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $user = Auth::user();
        $user->name = null;
        $user->email = null;
        $user->activated = 0;
        $user->status = -2;
        $user->save();

        $stream = Stream::where('streamer_id', $user->id)->firstOrFail();
        $stream->status = 0;
        $stream->title = null;
        $stream->save();

        Auth::logout();
        return redirect('/login');
    }

}
