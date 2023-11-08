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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable();
            $table->date('billing_start_date')->nullable();
            $table->date('billing_end_date')->nullable();
            $table->string('total_amount')->nullable();
            $table->integer('status')->nullable()->default(0)->comment("0 = Unpaid 1 = Paid");
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
        Schema::dropIfExists('biilings');
    }
};
