<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Stream;
use App\User;
use App\Viewer;

class StbViewersTableSeeder extends Seeder {

    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
        $streams = Stream::all();
        $date = $this->randDate();

        foreach($streams as $stream){
            $users = User::all();

            foreach($users as $user){
                $rank = ($stream->streamer_id == $user->id) ? 2 : 0;
                Viewer::create([
                    'stream_id'  => $stream->id,
                    'user_id'    => $user->id,
                    'rank'       => $rank,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }        
        }
	}
}