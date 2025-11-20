<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'tax',
        'discount',
        'total',
        'notes',
        'ordered_at',
        'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'ordered_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who placed this order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;
        return 'ORD-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'preparing' => 'Sedang Disiapkan',
            'ready' => 'Siap Diambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get status color for badge
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'preparing' => 'indigo',
            'ready' => 'green',
            'completed' => 'gray',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    /**
     * Calculate and update totals
     */
    public function calculateTotals()
    {
        $this->subtotal = $this->items()->sum('subtotal');
        $this->tax = round($this->subtotal * 0.10, 2); // 10% tax
        $this->total = $this->subtotal + $this->tax - $this->discount;
        $this->save();
    }

    /**
     * Format total in Indonesian Rupiah
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
