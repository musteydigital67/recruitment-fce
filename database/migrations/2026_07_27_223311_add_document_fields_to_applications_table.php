<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('passport_path')->nullable();
            $table->string('birth_certificate_path')->nullable();
            $table->string('olevel_result_path')->nullable();
            $table->string('degree_path')->nullable();
            $table->string('lga_certificate_path')->nullable();
            $table->string('nysc_certificate_path')->nullable();
            $table->string('masters_certificate_path')->nullable();
            $table->string('professional_certificate_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'passport_path',
                'birth_certificate_path',
                'olevel_result_path',
                'degree_path',
                'lga_certificate_path',
                'nysc_certificate_path',
                'masters_certificate_path',
                'professional_certificate_path',
            ]);
        });
    }
};