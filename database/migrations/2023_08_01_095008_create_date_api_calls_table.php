<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('date_api_calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contactid');
            $table->string('action');
            $table->unsignedBigInteger('gap');
            $table->string('start_date');
            $table->string('start_timezone')->nullable();
            $table->string('end_date');
            $table->string('end_timezone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('date_api_calls');
    }
};
