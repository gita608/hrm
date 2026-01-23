<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'job_posting_id',
        'applied_role',
        'applied_date',
        'resume_path',
        'cover_letter',
        'status',
        'notes',
        'experience_summary',
        'education',
        'skills',
        'is_active',
    ];

    protected $casts = [
        'applied_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the full name attribute.
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the job posting that this candidate applied for.
     */
    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }
}
