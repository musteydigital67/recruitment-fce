<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('title');                 // e.g. Assistant Lecturer
            $table->string('grade')->nullable();      // e.g. CONPCASS 01
            $table->enum('category', ['academic', 'non_academic']);
            $table->string('department')->nullable(); // e.g. School of General Education
            $table->text('requirements');
            $table->unsignedInteger('slots')->default(1);
            $table->boolean('is_open')->default(true);
            $table->date('closes_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
