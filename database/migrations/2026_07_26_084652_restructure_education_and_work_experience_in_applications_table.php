<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->json('education')->nullable()->after('institutions_attended');
            $table->json('work_experiences')->nullable()->after('work_experience');
            $table->text('professional_qualifications')->nullable()->after('qualifications');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['institutions_attended', 'work_experience', 'qualifications']);
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->text('institutions_attended')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('qualifications')->nullable();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['education', 'work_experiences', 'professional_qualifications']);
        });
    }
};
