<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting();
        $setting->name = 'Occasions limit';
        $setting->value = 20;
        $setting->save();

        $setting = new Setting();
        $setting->name = 'Contract expiration date';
        $setting->value = '15.06.2018';
        $setting->save();

        $setting = new Setting();
        $setting->name = 'Service fee';
        $setting->value = '50';
        $setting->save();
    }
}
