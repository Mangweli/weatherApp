<?php

namespace App\Repositories\Interfaces;

interface CityInterfaces {
    public function getCities();
    public function getSpecificCity(string $name);
    public function setCity(int $city_id, array $city_data);
    public function setNewCity(array $city_data);
}
