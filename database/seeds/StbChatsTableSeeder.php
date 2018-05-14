<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Viewer;
use App\Chat;

class StbChatsTableSeeder extends Seeder {

    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
        $viewers = Viewer::all();
        $date = $this->randDate();

        foreach($viewers as $viewer){

            Chat::create([
                'message'    => 'Coucou',
                'viewer_id'  => $viewer->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        
        }
	}
}