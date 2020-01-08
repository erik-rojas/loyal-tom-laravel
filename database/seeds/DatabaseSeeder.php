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
        $this->call(TagsTableSeeder::class);
        $this->call(ClientNamesTableSeeder::class);
        $this->call(CarennciesTaableSeeder::class);
        $this->call(SettingsTableSeeder::class);

    }
}
