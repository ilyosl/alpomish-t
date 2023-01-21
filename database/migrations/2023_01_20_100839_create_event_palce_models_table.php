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
        Schema::create('event_place', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('place');
            $table->smallInteger('row');
            $table->foreignIdFor(\App\Models\Events::class, 'event_id');
            $table->integer('price');
            $table->char('block_name', 2);
            $table->string('event_time');
            $table->date('event_date');
            $table->smallInteger('status')->default('0');
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
        Schema::dropIfExists('event_place');
    }
};
