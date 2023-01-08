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
        Schema::create('postDeviceLog', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('device_ip');
            $table->dateTime('comingDate');
            $table->jsonb('log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postDeviceLog');
    }
};
