<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id', 'full_name', 'place_of_birth', 'date_of_birth', 'marital_status',
        'next_of_kin_name', 'next_of_kin_address', 'next_of_kin_phone',
        'number_of_children', 'children_ages',
        'nationality', 'state_of_origin', 'lga_of_origin', 'phone', 'email', 'permanent_address',
        'institutions_attended', 'qualifications', 'work_experience', 'employment_status', 'present_salary',
        'publications', 'extra_curricular', 'additional_info',
        'referees', 'cv_path', 'credentials_path', 'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'referees' => 'array',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
