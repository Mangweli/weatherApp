<?php

namespace App\Repositories\Interfaces;

interface CityInterface {
    public function getCities();
    public function getSystemCities();
    public function getSpecificCity(string $name);
    public function setCity(int $city_id, array $city_data);
    public function setNewCity(array $city_data);
}
