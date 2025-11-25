<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_date',
        'period_start',
        'period_end',
        'total_income',
        'total_expense',
        'profit',
        'notes',
    ];

    protected $casts = [
        'report_date' => 'datetime',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}