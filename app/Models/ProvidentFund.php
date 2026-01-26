<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProvidentFund extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_contribution',
        'employer_contribution',
        'total_contribution',
        'employee_percentage',
        'employer_percentage',
        'contribution_date',
        'month',
        'year',
        'notes',
    ];

    protected $casts = [
        'employee_contribution' => 'decimal:2',
        'employer_contribution' => 'decimal:2',
        'total_contribution' => 'decimal:2',
        'employee_percentage' => 'decimal:2',
        'employer_percentage' => 'decimal:2',
        'contribution_date' => 'date',
    ];

    /**
     * Get the employee that owns the provident fund.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
