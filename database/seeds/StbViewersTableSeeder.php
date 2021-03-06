<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Stream;
use App\User;
use App\Viewer;

class StbViewersTableSeeder extends Seeder {

    private function randDate()
	{
        //Date aléatoire : createFromDate(annee, mois, jour)
		return Carbon::createFromDate(2017, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
        $streams = Stream::all();
        $date = $this->randDate();

        foreach($streams as $stream){
            $users = User::all();

            foreach($users as $user){
                $rank = ($stream->streamer_id == $user->id) ? 2 : 0;
                $follower = ($stream->streamer_id == $user->id) ? 1 : 0;

                Viewer::create([
                    'stream_id'  => $stream->id,
                    'user_id'    => $user->id,
                    'rank'       => $rank,
                    'is_follower'=> $follower,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }        
        }
	}
}