<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        //On récupère la valeur de l'id des admins
        $role = Role::where('name', 'admin')->firstOrFail();

        User::create([
            'pseudo'         => 'admin',                
            'name'           => str_random(10),
            'email'          => 'admin@admin.com',
            'activated'      => 1,
            'password'       => bcrypt('password'),
            'remember_token' => str_random(60),
            'role_id'        => $role->id,
        ]);

        //Guillaume
        User::create([
            'pseudo'         => 'reco',                
            'name'           => str_random(10),
            'email'          => 'spartandu54@hotmail.fr',
            'password'       => bcrypt('test'),
            'activated'      => 1,
            'remember_token' => str_random(60),
            'role_id'        => $role->id,
        ]);
    }
}
