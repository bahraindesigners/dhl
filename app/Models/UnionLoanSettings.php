<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnionLoanSettings extends Model
{
    protected $fillable = [
        'max_months',
        'receivers',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_months' => 'integer',
            'receivers' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public static function getActiveSettings(): ?self
    {
        return self::where('is_active', true)->first();
    }
}
