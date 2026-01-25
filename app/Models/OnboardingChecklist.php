<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingChecklist extends Model
{
    protected $fillable = [
        'onboarding_id',
        'template_id',
        'task_name',
        'description',
        'task_type',
        'is_completed',
        'due_date',
        'completed_date',
        'assigned_to',
        'order',
        'is_required',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'is_required' => 'boolean',
            'due_date' => 'date',
            'completed_date' => 'date',
        ];
    }

    public function onboarding(): BelongsTo
    {
        return $this->belongsTo(Onboarding::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(OnboardingTemplate::class, 'template_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
