<?php

use Illuminate\Database\Seeder;
use App\Theme;

class StbThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theme = Theme::firstOrNew(['name' => 'default']);
        if (!$theme->exists) {
            $theme->save();
        }
    }
}
