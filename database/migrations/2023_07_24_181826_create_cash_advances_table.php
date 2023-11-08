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
        Schema::create('cash_advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('c_amount');
            $table->string('purpose');
            $table->integer('pay_seq')->nullable();
            $table->integer('c_pay_sequence')->nullable();
            $table->integer('status')->nullable()->default(0)->comment("0 = Not Complete 1 = Completed");
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
        Schema::dropIfExists('cash_advances');
    }
};
