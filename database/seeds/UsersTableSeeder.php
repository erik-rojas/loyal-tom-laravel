<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marian = new User();
        $marian->name = 'Gian';
        $marian->email = 'zhovtyj11@gmail.com';
        $marian->password = bcrypt('gostreet2017');
        dd(bcrypt('123456'));
        /**Get the ID of ROLE - Admin*/
        $role_admin = Role::where('name', 'Admin')->first();
        $marian->role_id = $role_admin->id;
        $marian->save();

    }
}
