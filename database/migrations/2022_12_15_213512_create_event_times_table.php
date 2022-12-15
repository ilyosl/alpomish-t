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
        Schema::create('event_times', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Events::class, 'event_id')->constrained()->cascadeOnDelete();
            $table->date('eventDate');
            $table->time('eventTime');
            $table->integer('status')->default('0')->comment('0=no active, 1=active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_times');
    }
};
