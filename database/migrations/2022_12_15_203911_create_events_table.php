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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('age_limit', 10);
            $table->longText('desc')->nullable();

            $table->string('image')->nullable();
            $table->string('cover')->nullable();

            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->string('meta_desc');

            $table->tinyInteger('status')->default('0')->comment('0=no active, 1=active');;
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
        Schema::dropIfExists('events');
    }
};
