<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Viewer;
use App\Subscriber;

class StbSubscribersTableSeeder extends Seeder {

    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
        $viewers = Viewer::all();
        $date = $this->randDate();

        foreach($viewers as $viewer){

            Subscriber::create([
                'viewer_id'  => $viewer->id,
                'amount'     => 10,
                'renewable'  => 1,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        
        }
	}
}