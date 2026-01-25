<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_code',
        'title',
        'department_id',
        'designation_id',
        'no_of_positions',
        'start_date',
        'end_date',
        'job_type',
        'experience_level',
        'location',
        'salary_from',
        'salary_to',
        'description',
        'requirements',
        'benefits',
        'status',
        'is_active',
        // UAE-specific fields
        'uae_emirate',
        'uae_city',
        'visa_sponsorship',
        'work_permit_required',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'salary_from' => 'decimal:2',
        'salary_to' => 'decimal:2',
        'is_active' => 'boolean',
        'visa_sponsorship' => 'boolean',
        'work_permit_required' => 'boolean',
    ];

    /**
     * Get the department for this job posting.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the designation for this job posting.
     */
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    /**
     * Get all candidates for this job posting.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'job_posting_id');
    }
}
