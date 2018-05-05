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
    public function show(Request $request, $pseudo){
        $streamer = User::where('pseudo',$pseudo)
                    ->where('status',1)
                    ->first();        
        if(!$streamer)
            abort(404);
        
        $user = Auth::user();
        $user->token = $request->session()->get('_token');
        return view('stream.show', compact('streamer', 'user'));
    }

    /**
     * Update the stream's title
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\http\Response
     */
    public function updateTitle(Request $request){
        $stream = Stream::where('streamer_id', '=', Auth::user()->id)->first();

        if($stream){
            $stream->title = $request->get('title');
            $stream->save();
            return ["ok" => "Modification enregistrée"];
        }

        return ["erreur" => "Stream non trouvé"];
    }

    /**
     * Update the stream's status
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\http\Response
     */
    public function updateStatus(Request $request){
        $stream = Stream::where('streamer_id', '=', Auth::user()->id)->first();

        if($stream){
            $stream->status = ($request->get('status') == "true") ? 1 : 0;
            $stream->save();
            return ["ok" => "Modification enregistrée"];
        }

        return ["erreur" => "Stream non trouvé"];
    }

    /**
     * Recherche automatique des streams
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
