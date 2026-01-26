<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_number',
        'title',
        'letter_type',
        'employee_id',
        'content',
        'issue_date',
        'issued_by',
        'file_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
