<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function dailyForecast() {
        return $this->belongsTo(DailyForecast::class);
    }
}
