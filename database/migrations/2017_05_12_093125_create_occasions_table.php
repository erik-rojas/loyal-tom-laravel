<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccasionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occasions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->string('type');
            $table->integer('date');
            $table->date('due_date');
            $table->date('sms_date');
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->text('like')->nullable();
            $table->text('dislike')->nullable();
            $table->boolean('relative')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occasions');
    }
}
