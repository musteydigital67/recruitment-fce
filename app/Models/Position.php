<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'grade', 'category', 'department',
        'requirements', 'slots', 'is_open', 'closes_at',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'closes_at' => 'date',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }
}
