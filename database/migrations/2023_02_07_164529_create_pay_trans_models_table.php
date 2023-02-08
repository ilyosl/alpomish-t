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
            $table->bigInteger('pay_time')->nullable();
            $table->integer('stat')->nullable();
            $table->integer('reason')->nullable();
            $table->string('pay_id')->nullable();
            $table->string('pay_amount')->nullable();
            $table->bigInteger('pay_account')->default(0)->nullable();
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
