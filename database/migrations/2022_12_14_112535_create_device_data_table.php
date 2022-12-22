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
        Schema::create('device_data', function (Blueprint $table) {
            $table->id();
            $table->string('guid');
            $table->dateTime('request_time')->nullable();
            $table->string('ip')->nullable();
            $table->integer('device_id');
            $table->string('device_d_time');
            $table->integer('user_id')->nullable();
            $table->string('type');
            $table->json('device_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_data');
    }
};
