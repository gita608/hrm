<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resignation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'resignation_date',
        'notice_date',
        'last_working_day',
        'reason',
        'notes',
        'status',
        'is_active',
    ];

    protected $casts = [
        'resignation_date' => 'date',
        'notice_date' => 'date',
        'last_working_day' => 'date',
        'is_active' => 'boolean',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
