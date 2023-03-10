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
        Schema::create('application_for_katok_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\KatokServiceModel::class, 'katok_service_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->text('comment');
            $table->smallInteger('status')->default(0);
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
        Schema::dropIfExists('application_for_katok_services');
    }
};
