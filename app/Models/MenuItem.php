<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'notes',
        'is_available',
        'stock',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the orders that contain this menu item.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get category label in Indonesian
     */
    public function getCategoryLabelAttribute()
    {
        $labels = [
            'paket' => 'Menu Paket',
            'gyutan' => 'Spesial Gyutan',
            'dori' => 'Spesial Dori',
            'salmon' => 'Spesial Salmon',
            'nasi_goreng' => 'Spesial Nasi Goreng',
            'mie_bihun' => 'Mie/Bihun/Sohun/Kwetiau',
            'snack' => 'Snack',
            'minuman' => 'Minuman',
        ];

        return $labels[$this->category] ?? $this->category;
    }

    /**
     * Format price in Indonesian Rupiah
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Check if menu is available
     */
    public function isInStock()
    {
        if ($this->stock === -1) {
            return $this->is_available;
        }

        return $this->is_available && $this->stock > 0;
    }
}
