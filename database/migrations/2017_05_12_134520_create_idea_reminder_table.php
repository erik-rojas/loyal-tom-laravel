<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeaReminderTable extends Migration
{

    public function up()
    {
        Schema::create('idea_reminder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idea_id')->unsigned();
            $table->foreign('idea_id')->references('id')->on('ideas')->onDelete('cascade');
            $table->integer('reminder_id')->unsigned();
            $table->foreign('reminder_id')->references('id')->on('reminders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('idea_reminder');
    }
}
