<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'days_per_year',
        'is_paid',
        'requires_approval',
        'description',
        'is_active',
    ];

    protected $casts = [
        'days_per_year' => 'integer',
        'is_paid' => 'boolean',
        'requires_approval' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get all leaves of this type.
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }
}
