<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyForecast extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function dailyFeellike() {
        return $this->hasOne(FeelLike::class);
    }

    public function dailyTemp() {
        return $this->hasOne(Temperature::class);
    }

    public function dailyWeather() {
        return $this->hasOne(Weather::class);
    }
}
