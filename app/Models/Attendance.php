<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'break_start',
        'break_end',
        'total_hours',
        'break_duration',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        // Don't cast time fields as datetime since they're stored as time type
        // They'll be retrieved as strings in H:i:s format
    ];

    /**
     * Get the employee for this attendance.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
