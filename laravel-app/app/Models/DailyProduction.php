<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyProduction extends Model
{
    protected $fillable = ['well_id', 'date', 'production_value'];

    // Связь: Показатель относится к определенной скважине
    public function well()
    {
        return $this->belongsTo(Well::class);
    }
}