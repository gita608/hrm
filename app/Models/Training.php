<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'training_type_id',
        'trainer_id',
        'start_date',
        'end_date',
        'description',
        'status',
        'location',
        'max_participants',
        'is_active',
        // UAE-specific fields
        'uae_labor_law_compliance',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'uae_labor_law_compliance' => 'boolean',
    ];

    /**
     * Get the training type that owns the training.
     */
    public function trainingType(): BelongsTo
    {
        return $this->belongsTo(TrainingType::class, 'training_type_id');
    }

    /**
     * Get the trainer that owns the training.
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
}
