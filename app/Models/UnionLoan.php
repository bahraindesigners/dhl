<?php

namespace App\Models;

use App\Events\UnionLoanCreated;
use App\Events\UnionLoanUpdated;
use App\LoanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class UnionLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'months',
        'status',
        'note',
        'rejected_reason',
    ];

    protected static function booted(): void
    {
        static::created(function (UnionLoan $unionLoan) {
            UnionLoanCreated::dispatch($unionLoan);
        });

        static::updated(function (UnionLoan $unionLoan) {
            // Only fire the event if the status was actually changed
            if ($unionLoan->wasChanged('status')) {
                UnionLoanUpdated::dispatch($unionLoan);
            }
        });
    }

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
