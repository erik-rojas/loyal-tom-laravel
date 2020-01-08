<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->save();

        $role_client = new Role();
        $role_client->name = 'ClientAdvisor';
        $role_client->save();

        $role_reminder_creator = new Role();
        $role_reminder_creator->name = 'ReminderCreator';
        $role_reminder_creator->save();

        $role_reminder_sender = new Role();
        $role_reminder_sender->name = 'ReminderSender';
        $role_reminder_sender->save();

    }
}
