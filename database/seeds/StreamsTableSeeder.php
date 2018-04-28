<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StreamsTableSeeder extends Seeder {

    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
		DB::table('stb_streams')->delete();

        $date = $this->randDate();
        DB::table('stb_streams')->insert([
            'titre' => 'Titre',
            'streamer_id' => rand(1, 2),
            'created_at' => $date,
            'updated_at' => $date
        ]);
	}
}