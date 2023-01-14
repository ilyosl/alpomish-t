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
        Schema::create('table_kassa_read', function (Blueprint $table) {
            $table->id();
            $table->string('ipAddress');
            $table->foreignIdFor(\App\Models\KatokQrcodeModel::class,'katokqrcode_id')->constrained()->onDelete('CASCADE');
            $table->smallInteger('is_read')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_kassa_read');
    }
};
