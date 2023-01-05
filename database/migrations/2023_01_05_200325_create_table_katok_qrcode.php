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
        Schema::create('katokQrcode', function (Blueprint $table) {
            $table->id();
            $table->uuid('qrcode');
            $table->smallInteger('status')->default('0');
            $table->timestampTz('startDate');
            $table->timestampTz('finishDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('katokQrcode');
    }
};
