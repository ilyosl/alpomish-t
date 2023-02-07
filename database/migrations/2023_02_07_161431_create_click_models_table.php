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
        Schema::create('click', function (Blueprint $table) {
            $table->id();
            $table->integer('click_trans_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->integer('click_paydoc_id')->nullable();
            $table->integer('action')->nullable();
            $table->integer('error')->nullable();
            $table->integer('merchant_confirm_id')->nullable();
            $table->integer('amount')->nullable();
            $table->string('merchant_trans_id')->nullable();
            $table->string('error_note')->nullable();
            $table->string('sign_time')->nullable();
            $table->string('sight_string')->nullable();
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
        Schema::dropIfExists('click');
    }
};
