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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable();
            $table->string('total_deduction')->nullable();
            $table->string('ca_deduction')->nullable();
            $table->string('df_deduction')->nullable();
            $table->string('total_rate')->nullable();
            $table->string('total_net_salary')->nullable();
            $table->date('payroll_start_date')->nullable();
            $table->date('payroll_end_date')->nullable();
            $table->integer('status')->default(0)->comment("0 = Unpaid 1 = Paid");
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
        Schema::dropIfExists('payrolls');
    }
};
