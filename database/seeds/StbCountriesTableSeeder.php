<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Countries;

class StbCountriesTableSeeder extends Seeder {
	public function run()
	{
        Countries::create([
            'code'    => 'Col',
            'name'  => 'Colombia',
            'svg' => 'https://restcountries.eu/data/col.svg'
        ]);
	}
}