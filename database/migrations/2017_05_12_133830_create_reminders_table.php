<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindersTable extends Migration
{

    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('occasion_id')->unsigned();
            $table->string('status')->default('Pending');
            $table->boolean('email_sent')->default(false);
            $table->boolean('sms_sent')->default(false);
            $table->boolean('seen')->default(false);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}
