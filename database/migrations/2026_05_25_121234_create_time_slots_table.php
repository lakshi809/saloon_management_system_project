<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

public function up()
{
    Schema::create('time_slots', function (Blueprint $table) {
        $table->id();
        $table->time('slot_time');
        $table->tinyInteger('is_available')->default(1);
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
        Schema::dropIfExists('time_slots');
    }
}
