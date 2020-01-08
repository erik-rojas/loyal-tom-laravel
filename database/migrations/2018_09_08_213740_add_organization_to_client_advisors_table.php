<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrganizationToClientAdvisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_advisors', function (Blueprint $table) {
            $table->string('organization')->nullable();
            $table->string('role')->nullable();
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
            $table->dropColumn('organization');
            $table->dropColumn('role');
        });
    }
}
