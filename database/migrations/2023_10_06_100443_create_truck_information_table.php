<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id');
            $table->integer('status')->default(1)->comment("1 = Assigned 2 = Picked-up 3 = Departure 4 = Delivey on the way 5 = Delivered 6 = Arrived at the station");
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
        Schema::dropIfExists('truck_information');
    }
};
