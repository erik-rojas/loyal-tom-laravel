<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOccasionLimitToClientAdvisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_advisors', function (Blueprint $table) {
            $table->unsignedInteger('occasion_limit')->default(25)->after('birthday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_advisors', function (Blueprint $table) {
            $table->dropColumn('occasion_limit');
        });
    }
}
