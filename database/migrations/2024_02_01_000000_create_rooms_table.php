<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->string('room_type'); // e.g. Dorm, Private, Twin
            $table->integer('capacity');
            $table->decimal('price_per_night', 8, 2);
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // stored file path
            $table->enum('status', ['available', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
