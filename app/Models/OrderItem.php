<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'unit_price',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order this item belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the menu item.
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Calculate subtotal before saving
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->subtotal = $model->quantity * $model->unit_price;
        });

        static::updating(function ($model) {
            $model->subtotal = $model->quantity * $model->unit_price;
        });
    }
}
