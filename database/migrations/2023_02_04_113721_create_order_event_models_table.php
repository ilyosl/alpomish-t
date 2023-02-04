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
        Schema::create('order_event', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\OrdersModel::class, 'order_id');
            $table->foreignIdFor(\App\Models\EventPlaceModel::class, 'event_place_id');
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
        Schema::dropIfExists('order_event');
    }
};
