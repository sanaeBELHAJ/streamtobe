<?php

use Illuminate\Database\Seeder;
use App\ReportCat;

class StbReportsCatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theme = ReportCat::firstOrNew(['name' => 'default']);
        if (!$theme->exists) {
            $theme->save();
        }
    }
}
