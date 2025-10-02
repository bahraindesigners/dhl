<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlHasalaSettings extends Model
{
    use HasFactory;

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

    public static function getSingleton(): self
    {
        return self::first() ?? self::create([
            'max_months' => 24,
            'receivers' => [
                [
                    'name' => 'Al Hasala Admin',
                    'email' => 'alhasala@example.com',
                ],
            ],
            'is_active' => true,
        ]);
    }
}
