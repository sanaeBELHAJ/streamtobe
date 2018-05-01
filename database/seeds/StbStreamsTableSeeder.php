<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Type;
use App\Stream;

class StbStreamsTableSeeder extends Seeder {

    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
        $users = User::all();
        $type = Type::where('name', 'default')->firstOrFail();
        $date = $this->randDate();

        foreach($users as $user){

            Stream::create([
                'title' => 'Titre',
                'streamer_id' => $user->id,
                'type_id' => $type->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        
        }
	}
}