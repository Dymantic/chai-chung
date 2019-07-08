<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffCostEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_cost_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('staff_cost_report_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->float('total_hours');
            $table->float('overtime_hours');
            $table->integer('hourly_rate');
            $table->float('cost');
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
        Schema::dropIfExists('staff_cost_entries');
    }
}
