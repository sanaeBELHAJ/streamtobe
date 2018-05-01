<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        //$this->call(StbMessagesTableSeeder::class);

        $this->call(StbThemesTableSeeder::class);
        $this->call(StbTypesTableSeeder::class);

        $this->call(StbStreamsTableSeeder::class);
        $this->call(StbViewersTableSeeder::class);
        $this->call(StbChatsTableSeeder::class);
    }
}
