<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stand_templates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['current', 'next'])->default('current');
            $table->json('week_schedule');
            $table->unsignedBigInteger('stand_id');
            $table->unsignedBigInteger('congregation_id');
            $table->timestamps();

            $table->foreign('stand_id')->on('stands')->references('id');
            $table->foreign('congregation_id')->on('congregations')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stand_templates');
    }
}
