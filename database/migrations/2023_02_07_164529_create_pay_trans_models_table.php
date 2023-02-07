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
        Schema::create('pay_trans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pay_time');
            $table->integer('stat');
            $table->integer('reason');
            $table->string('pay_id');
            $table->string('pay_amount');
            $table->string('pay_account');
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
        Schema::dropIfExists('pay_trans');
    }
};
