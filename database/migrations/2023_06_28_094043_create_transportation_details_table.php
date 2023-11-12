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
        Schema::create('transportation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable();
            $table->foreignId('driver_id')->nullable();
            $table->foreignId('helper_id')->nullable();
            $table->foreignId('truck_id')->nullable();
            $table->string('status')->nullable()->default(1)->comment("1 = To be pick-up 
            2 = To be picked-up 3 = Departure 4 = In Route 5 = Delivered");            
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
        Schema::dropIfExists('transportation_details');
    }
};
