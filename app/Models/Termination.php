<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Termination extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'termination_date',
        'notice_date',
        'type',
        'reason',
        'notes',
        'is_active',
        // UAE-specific fields
        'visa_cancellation_date',
        'labor_card_cancellation_date',
    ];

    protected $casts = [
        'termination_date' => 'date',
        'notice_date' => 'date',
        'visa_cancellation_date' => 'date',
        'labor_card_cancellation_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
