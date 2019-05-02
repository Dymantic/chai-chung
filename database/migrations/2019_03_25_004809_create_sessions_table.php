<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('service_period');
            $table->integer('client_id')->unsigned();
            $table->integer('engagement_code_id')->unsigned();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('on_holiday')->default(0);
            $table->boolean('on_make_up_day')->default(0);
            $table->integer('overtime_minutes')->unsigned()->nullable();
            $table->integer('overtime_set_by')->unsigned()->nullable();
            $table->string('manual_overtime_reason')->nullable();
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
        Schema::dropIfExists('sessions');
    }
}
