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
        Schema::create('updated_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('t_id');
            $table->integer('status')->comment("2 = Picked-up 3 = Departure 5 = Delivered");
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
        Schema::dropIfExists('updated_times');
    }
};
