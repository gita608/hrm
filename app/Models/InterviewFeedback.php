<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'interviewer_id',
        'rating',
        'feedback',
        'recommendation',
        'strengths',
        'weaknesses',
        'additional_notes',
    ];

    /**
     * Get the interview that this feedback belongs to.
     */
    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }

    /**
     * Get the interviewer (user) who provided this feedback.
     */
    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }
}
