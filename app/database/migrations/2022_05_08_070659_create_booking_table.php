<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("booking", function (Blueprint $table) {
            $table->id();
            $table->foreignId("car_id")->references("id")->on("cars");
            $table->foreignId("user_id")->references("id")->on("users");
            $table->timestamp("date_start");
            $table->timestamp("date_end");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking');
    }
}
