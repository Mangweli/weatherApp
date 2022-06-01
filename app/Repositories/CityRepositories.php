<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityInterface;

class CityRepositories implements CityInterface
{
    public function getCities() {

    }

    public function getSystemCities() :array {
       return City::where('created_by', 'system')->get()->toArray();
    }

    public function getSpecificCity(string $name) {

    }

    public function setCity(int $city_id, array $city_data) {

    }

    public function setNewCity(array $city_data) {

    }
}
