<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'from_date',
        'to_date',
        'days',
        'reason',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'admin_notes',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'days' => 'integer',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the employee for this leave.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the leave type for this leave.
     */
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    /**
     * Get the approver for this leave.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
