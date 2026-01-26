<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_code',
        'referrer_id',
        'referred_first_name',
        'referred_last_name',
        'referred_email',
        'referred_phone',
        'job_posting_id',
        'referral_date',
        'status',
        'referral_bonus',
        'bonus_status',
        'bonus_paid_date',
        'notes',
        'referred_skills',
        'referred_experience',
        'is_active',
    ];

    protected $casts = [
        'referral_date' => 'date',
        'bonus_paid_date' => 'date',
        'referral_bonus' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the full name of the referred person.
     */
    public function getReferredNameAttribute(): string
    {
        return "{$this->referred_first_name} {$this->referred_last_name}";
    }

    /**
     * Get the employee who made the referral.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the job posting this referral is for.
     */
    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }
}
