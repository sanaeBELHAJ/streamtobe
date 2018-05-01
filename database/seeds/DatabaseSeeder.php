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
        $this->call(ThemesTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MessagesTableSeeder::class);

        $this->call(StreamsTableSeeder::class);
        $this->call(ViewersTableSeeder::class);
        $this->call(ChatsTableSeeder::class);
    }
}
