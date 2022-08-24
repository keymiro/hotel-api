<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->float('amount');
            $table->string('accommodations')->nullable();

            $table->unsignedBigInteger('type_room_id')->comment('Id del tipo de habitación');
            $table->foreign('type_room_id')->references('id')->on('type_rooms');

            $table->unsignedBigInteger('hotel_id')->comment('Id del hotel al cual correspode la habitación');
            $table->foreign('hotel_id')->references('id')->on('hotels');

            $table->unsignedBigInteger('user_created_id')->comment('Id del usuario creador del registro');
            $table->foreign('user_created_id')->references('id')->on('users');

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
        Schema::dropIfExists('rooms');
    }
}
