<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    protected $fillable = [
        'name',
        'type',
        'is_active',
        'settings',
        'last_activity'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'last_activity' => 'datetime'
    ];

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function updateActivity(): void
    {
        $this->update(['last_activity' => now()]);
    }
} 