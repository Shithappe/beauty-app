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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('username');
            $table->string('phone');

            $table->unsignedBigInteger('salon_id');
            $table->foreign('salon_id')
                  ->references('id')->on('salons')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')
                ->references('id')->on('services')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
