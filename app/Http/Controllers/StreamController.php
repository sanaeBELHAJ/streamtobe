<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Stream;
use App\Viewer;
use Illuminate\Support\Facades\Auth;

class StreamController extends Controller
{
    protected $nbPerPage = 4;

    public function __construct(){

    }
    
    /**
     * Display a listing of the actives streams
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
		$streams = Stream::where('status', 1)->get();
        return view('stream.index', compact('streams'));
    }

    /**
     * Display a listing of the favorites streams
     * 
     * @return \Illuminate\Http\Response
     */
    public function favorites(){
        $favorites = Viewer::where('user_id', Auth::user()->id)
                            ->where('is_follower',1)
                            ->get();
        $streams = [];
        foreach($favorites as $favorite)
            $streams[] = $favorite->stream;

        return view('stream.index', compact('streams'));
    }

    /**
     * Display the specified resource
     * 
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function show($pseudo){
        $user = User::where('pseudo',$pseudo)
                    ->where('status',1)
                    ->first();
        if(!$user)
            abort(404);
        return view('stream.show', compact('user'));
    }

    /**
     * Store a message
     * 
     */
    public function storeMessage($message){
        $user = Auth::user();
        if($user){
            
        }
    }

    /**
     * 
     */
    public function autocomplete(){
        $term = Input::get('term');
        $results = array();
        
        $queries = User::where('pseudo', 'LIKE', '%'.$term.'%')->take(5)->get();
        
        foreach ($queries as $query)
            $results[] = [ 
                    'avatar' => asset('storage/'.$query->avatar),
                    'value' => $query->pseudo
                ];

        return Response::json($results);
    }
}
