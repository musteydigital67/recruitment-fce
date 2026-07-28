<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('nin_path')->nullable();
            $table->string('primary_certificate_path')->nullable();
            $table->string('trcn_certificate_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'nin_path',
                'primary_certificate_path',
                'trcn_certificate_path',
            ]);
        });
    }
};