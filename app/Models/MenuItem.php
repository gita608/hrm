<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'route',
        'url',
        'parent_id',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Get the parent menu item
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    // Get the child menu items
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    // Scope for active menu items
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for root menu items (items without parent)
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }
}
