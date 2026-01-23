<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'job_title',
        'interviewer_id',
        'interview_date',
        'interview_time',
        'location',
        'status',
        'notes',
        'description',
        'is_active',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the candidate (user) for this interview.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get the interviewer (user) for this interview.
     */
    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    /**
     * Get all feedback for this interview.
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(InterviewFeedback::class);
    }
}
