<?php

use Illuminate\Database\Seeder;
use App\Theme;
use App\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theme = Theme::where('name', 'default')->firstOrFail();

        Type::create([            
            'name'      => 'default',
            'theme_id'  => $theme->id,
        ]);
    }
}
