<?php

namespace App\Constants;

/**
 * Menu Category Constants
 * Centralized category definitions to avoid duplication across controllers
 */
class MenuCategory
{
    /**
     * Category labels mapping
     */
    public const LABELS = [
        'paket' => 'Menu Paket',
        'gyutan' => 'Spesial Gyutan',
        'dori' => 'Spesial Dori',
        'salmon' => 'Spesial Salmon',
        'nasi_goreng' => 'Spesial Nasi Goreng',
        'mie_bihun' => 'Mie/Bihun/Sohun/Kwetiau',
        'snack' => 'Snack',
        'minuman' => 'Minuman',
        'lainnya' => 'Menu Lainnya',
    ];

    /**
     * Get label for a specific category
     *
     * @param string $key
     * @return string
     */
    public static function getLabel(string $key): string
    {
        return self::LABELS[$key] ?? ucfirst($key);
    }

    /**
     * Get all category labels
     *
     * @return array
     */
    public static function all(): array
    {
        return self::LABELS;
    }

    /**
     * Get all category keys
     *
     * @return array
     */
    public static function keys(): array
    {
        return array_keys(self::LABELS);
    }

    /**
     * Check if category exists
     *
     * @param string $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return array_key_exists($key, self::LABELS);
    }

    /**
     * Get validation rule string for categories
     *
     * @return string
     */
    public static function validationRule(): string
    {
        return 'in:' . implode(',', self::keys());
    }
}
