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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->date('date');
            $table->time('pick_up_time');
            $table->time('transportation_time');
            $table->string('origin');
            $table->string('destination');
            $table->integer('tons')->nullable();
            $table->integer('status')->default('0')->comment("0 = Pending 1 = Approved");
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
        Schema::dropIfExists('bookings');
    }
};
