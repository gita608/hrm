<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OnboardingTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'department_id',
        'designation_id',
        'is_active',
        'duration_days',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function onboardings(): HasMany
    {
        return $this->hasMany(Onboarding::class, 'template_id');
    }

    public function checklistItems(): HasMany
    {
        return $this->hasMany(OnboardingChecklist::class, 'template_id');
    }
}
