<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Type;

class StreamsTableSeeder extends Seeder {

    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

	public function run()
	{
        $user = User::where('pseudo', 'admin')->firstOrFail();
        $type = Type::where('name', 'default')->firstOrFail();

        $date = $this->randDate();
        DB::table('stb_streams')->insert([
            'titre' => 'Titre',
            'streamer_id' => $user->id,
            'type_id' => $type->id,
            'created_at' => $date,
            'updated_at' => $date
        ]);
	}
}