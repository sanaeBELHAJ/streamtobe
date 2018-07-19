<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Mail;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Theme;
use App\Type;
use App\Stream;
use App\Viewer;

use App\Http\Requests\SupportRequest;

class HomeController extends Controller
{
    public function __construct(){
        
    }
    
     /**
     * Display a listing of the actives streams
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $themes = Theme::all();

        if(Auth::user()){
            $favorites = Viewer::where('user_id', Auth::user()->id)
                                ->where('is_follower',1)
                                ->get();
            $followed = [];
            foreach($favorites as $favorite){
                if($favorite->stream->status==1)
                    $followed[] = $favorite->stream;
            }

            $viewers = Auth::user()->stream->viewers; //Viewers(/Followers) de l'utilisateur
            //Mes dons reçus du mois
            $donations = 0;
            $followers = [];
            foreach ($viewers as $viewer) {
                if($viewer->rank >= 0 && $viewer->is_follower == 1)
                    $followers[] = $viewer;

                foreach ($viewer->donations as $donation){
                    if(date('Ym', strtotime($donation->created_at)) == date('Ym'))
                        $donations += $donation->amount;
                }
            }
        }
        else
            $listSlider = str_replace("public/", "storage/", Storage::files("public/welcome"));

        return view('welcome', compact('followed', 'themes', 'listSlider', 'viewers', 'followers', 'donations'));
    }
    
     /**
     * Display a listing of the actives streams
     * 
     * @return \Illuminate\Http\Response
     */
    public function cgu(){
       
        return view('cgu.cgu');
    }
    
    /**
     * Valid the cookies use
     * 
     */
    public function valid_cookie(){
        if(!isset($_COOKIE['valid_cookie'])) {
            setcookie("valid_cookie", 1, time()+60*60*24*30*12);//Expiration dans 1 an
        }
    }

    /**
     * Send an email to the staff members
     * 
     */
    public function support(SupportRequest $request){
        $datas = [
            "from" => (Auth::user()) ? Auth::user()->email : $request->input('exped'),
            "content" => $request->input('opinion')
        ];
        Mail::send('account.support', $datas, function($message){
            $message->to(env("MAIL_USERNAME"));
            $message->subject("Un utilisateur vous a contacté");
        });
        return response()->json(['ok' => 'ok']);
    }
    
    /**
     * Check new message
     */
    public function checkMessage(Request $request){
        if(Auth::user()){
            return DB::table('stb_messages')
                    ->select('id')
                    ->where('status', '=', 2)
                    ->where('user_receiv', '=', Auth::user()->id)
                    ->get();
        }
        return null;
    }
}
