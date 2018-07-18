<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Music;
use App\Theme;
use App\Type;
use App\Stream;
use App\Viewer;
use App\ReportCat;
use App\Report;
use App\Countries;
use App\Http\Requests\SearchStreamRequest;
use Illuminate\Support\Facades\Auth;

class StreamController extends Controller
{
    public function __construct(){

    }
    
    /**
     * Display a listing of the actives streams
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(SearchStreamRequest $request){
        //Liste des streams actifs
        $streams = Stream::where('status', 1)->get();

        if(!empty($request->all())){
            $streams = $streams->filter(function($stream, $key) use($request){
                $return = true;

                //Pays
                if($request->input("country") && $stream->user->id_countries != $request->input("country"))
                    $return = false;

                //Titre du stream
                if($request->input("name") && stristr($stream->title, $request->input("name")) === FALSE)
                    $return = false;

                //Thème du stream
                if($request->input("theme") && $stream->type->id != $request->input("theme"))
                    $return = false;

                return $return;
            });
        }
        
        if(Auth::user()){
            $favorites = Viewer::where('user_id', Auth::user()->id)
                                ->where('is_follower',1)
                                ->get();
            $followed = [];
            foreach($favorites as $favorite)
                $followed[] = $favorite->stream;
        }
        $themes = Theme::all();
        $countries = Countries::all();
        
        $inputs = [
            "name" => $request->input('name') ?? null,
            "theme" => $request->input('theme') ?? null,
            "country" => $request->input('country') ?? null
        ];;

        return view('stream.index', compact('streams', 'followed', 'themes','countries', 'inputs'));
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
        
        $themes = Theme::all();
        $user = Auth::user();
        $musics = ($user && $user->pseudo == $pseudo) ? Music::where("status", "=", 0)->get() : null;
        if($user){
            $user->token = $request->session()->get('_token');
            $reportCat = ReportCat::all();
            $report = Report::where('victim_id','=',$user->id)
                            ->where('guilty_id','=',$streamer->id)
                            ->where('status','=',1)
                            ->first();
        }
        return view('stream.show', compact('themes','streamer', 'user', 'musics','reportCat','report'));
    }

    /**
     * Update the stream's title
     * 
     * @param \Illuminate\http\Request $request
     * @return \Illuminate\http\Response
     */
    public function updateStream(Request $request){
        $stream = Stream::where('streamer_id', '=', Auth::user()->id)->first();

        if($stream){
            //Title
            if($request->get('config') == 'title')
                $stream->title = $request->get('value');
            
            //Status
            if($request->get('config') == 'status')
                $stream->status = ($request->get('value') == "true") ? 1 : 0;
            
            //Type
            if($request->get('config') == 'type'){
                $type = Type::where('name', '=', $request->get('value'))->first();
                if($type)
                    $stream->type_id = $type->id;
                else
                    return ["erreur" => "Type selectionné introuvable"];
            }

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
        
        $queries = User::where('pseudo', 'LIKE', '%'.$term.'%')
                        ->where("status",'>=', 1)
                        ->take(5)
                        ->get();
        
        foreach ($queries as $query)
            $results[] = [ 
                    'avatar' => asset('storage/'.$query->avatar),
                    'value' => $query->pseudo
                ];

        return Response::json($results);
    }

    /**
     * Ajout d'une musique en BDD
     */
    public function addMusic(Request $request){
        $title = trim($request->get('title'));
        if($title == "") 
            return null;
        
        $music = Music::create([
            'title' => $title,
            'mark'   => 0,
            'qtty_votes'  => 0, 
            'status' => 1,
            'stream_id' => Auth::user()->stream->id
        ]);

        return $music;
    }

    /**
     * Liste des notes pour chaque musique
     */
    public function getMarks(Request $request){
        $currentsSongs = $request->get('currentsSongs');

        $musics = Music::where('status', '=', 1)
                        ->where('stream_id', '=', Auth::user()->stream->id)
                        ->whereIn('id', [$currentsSongs])
                        ->get();

        foreach($musics as $music){
            $music->total = "?";
            if($music->qtty_votes)
                $music->total = floatval($music->mark) / intval($music->qtty_votes);
        }
        
        return $musics;
    }
}
