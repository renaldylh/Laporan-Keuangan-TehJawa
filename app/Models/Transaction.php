<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_date',
        'amount',
        'description',
        'type', // 'income' or 'expense'
        'payment_method',
        'receipt_path',
        'receipt_filename',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        $clearCache = function ($transaction) {
            $userId = $transaction->user_id;
            if ($userId) {
                // Clear transaction list cache for pages 1 to 5
                for ($page = 1; $page <= 5; $page++) {
                    foreach (['all', 'income', 'expense'] as $type) {
                        cache()->forget("transactions_{$userId}_{$page}_{$type}");
                    }
                }
                // Clear dashboard cache
                cache()->forget('dashboard_' . $userId . '_' . now()->format('Y-m-d_H'));
            }
        };

        static::created($clearCache);
        static::updated($clearCache);
        static::deleted($clearCache);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}