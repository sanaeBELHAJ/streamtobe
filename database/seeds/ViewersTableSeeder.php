<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Stream;
use App\User;
use App\Viewer;

class ViewersTableSeeder extends Seeder {

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

            Viewer::create([
                'stream_id'  => $stream->id,
                'user_id'    => $user->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        
        }
	}
}