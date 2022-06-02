<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function dailyForecast() {
        return $this->hasMany(DailyForecast::class);
    }

    public function dailyFeellike() {
        return $this->hasMany(FeelLike::class);
    }

    public function dailyWeather() {
        return $this->hasMany(Weather::class);
    }

    public function dailyTemp() {
        return $this->hasMany(Temperature::class);
    }
}
