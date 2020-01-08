<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CarennciesTaableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * CHF, USD and EUR
     * @return void
     */
    public function run()
    {
        $chf = new Currency();
        $chf->name = 'CHF';
        $chf->rate = '1';
        $chf->editable = false;
        $chf->save();

        $usd = new Currency();
        $usd->name = 'USD';
        $usd->rate = '1';
        $usd->editable = true;
        $usd->save();

        $eur = new Currency();
        $eur->name = 'EUR';
        $eur->rate = '1';
        $eur->editable = true;
        $eur->save();

    }
}
