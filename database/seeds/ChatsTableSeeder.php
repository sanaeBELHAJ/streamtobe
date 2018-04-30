<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Stream;
use App\Chat;

class ChatsTableSeeder extends Seeder {

    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
        $streams = Stream::all();
        $date = $this->randDate();

        foreach($streams as $stream){
            $user = User::inRandomOrder()->first();

            Chat::create([
                'message' => 'Coucou',
                'stream_id' => $stream->id,
                'user_id'   => $user->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        
        }
	}
}