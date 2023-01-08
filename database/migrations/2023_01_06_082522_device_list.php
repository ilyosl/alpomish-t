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
        Schema::create('deviceList', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->ipAddress('ip_address');
            $table->smallInteger('type')->default('0')->comment('0-enter, 1-exit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deviceList');
    }
};
