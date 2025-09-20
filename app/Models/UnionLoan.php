<?php

namespace App\Models;

use App\LoanStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class UnionLoan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'months',
        'status',
        'note',
        'rejected_reason',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'months' => 'integer',
            'status' => LoanStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberProfile(): HasOneThrough
    {
        return $this->hasOneThrough(MemberProfile::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}
