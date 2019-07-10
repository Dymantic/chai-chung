<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientCostEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_cost_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_cost_report_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->float('total_hours');
            $table->float('overtime_hours');
            $table->integer('cost');
            $table->integer('annual_revenue');
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
        Schema::dropIfExists('client_cost_entries');
    }
}
