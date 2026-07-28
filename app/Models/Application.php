<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'position_id', 'first_name', 'middle_name', 'surname', 'date_of_birth', 'marital_status',
        'next_of_kin_name', 'next_of_kin_address', 'next_of_kin_phone',
        'number_of_children', 'children_ages',
        'nationality', 'state_of_origin', 'lga_of_origin', 'phone', 'email', 'permanent_address',
        'education', 'professional_qualifications', 'work_experiences', 'employment_status', 'present_salary',
        'publications', 'extra_curricular', 'additional_info',
        'referees', 'status',
        'passport_path', 'birth_certificate_path', 'olevel_result_path', 'degree_path',
        'lga_certificate_path', 'nysc_certificate_path', 'masters_certificate_path', 'professional_certificate_path',
        'nin_path', 'primary_certificate_path', 'trcn_certificate_path',
        'interview_date', 'interview_time', 'interview_location', 'interview_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'interview_date' => 'date',
        'interview_time' => 'datetime:H:i',
        'referees' => 'array',
        'education' => 'array',
        'work_experiences' => 'array',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim(collect([$this->first_name, $this->middle_name, $this->surname])->filter()->implode(' '));
    }
}

