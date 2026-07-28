<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();

            // 1-4
            $table->string('full_name');
            $table->string('state_of_birth')->nullable();
            $table->string('lga_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('marital_status')->nullable();

            // 5-6
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->unsignedInteger('number_of_children')->default(0);
            $table->string('children_ages')->nullable();

            // 7-9
            $table->string('nationality')->default('Nigerian');
            $table->string('state_of_origin')->nullable();
            $table->string('lga_of_origin')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->text('permanent_address')->nullable();

            // 10-13
            $table->text('institutions_attended')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('work_experience')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('present_salary')->nullable();

            // 14-16
            $table->text('publications')->nullable();
            $table->text('extra_curricular')->nullable();
            $table->text('additional_info')->nullable();

            // 17 - three referees
            $table->json('referees')->nullable();

            // Uploads
            $table->string('cv_path')->nullable();
            $table->string('credentials_path')->nullable();

            $table->enum('status', ['pending', 'shortlisted', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

