<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'calculation_type',
        'amount',
        'percentage',
        'description',
        'is_taxable',
        'is_active',
        'applies_to_all',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'is_taxable' => 'boolean',
        'is_active' => 'boolean',
        'applies_to_all' => 'boolean',
    ];
}
