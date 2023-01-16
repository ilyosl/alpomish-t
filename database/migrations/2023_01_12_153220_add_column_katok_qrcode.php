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
        Schema::table('katokQrcode', function (Blueprint $table) {
            $table->integer('jazo_price')->default('0');
            $table->string('jazo_type')->default('Click');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('katokQrcode',['jazo_price','jazo_type ']);
    }
};
