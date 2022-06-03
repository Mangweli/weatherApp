<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityInterface;

class CityRepository implements CityInterface
{
    public function getCities($paginate) : object {
        return City::paginate($paginate);
    }

    public function getCitiesByID(array $city_ids) : array {
        return City::select('id', 'name', 'lat', 'lon')
                    ->whereIn('id', $city_ids)
                    ->get()
                    ->toArray();
    }

    public function getSystemCities() : array {
       return City::where('created_by', 'system')->get()->toArray();
    }
    /**
     *
     * TODO::ADD MORE CITY FUNCTIONALITIES
     */

    // public function getSpecificCity(string $name) {

    // }

    // public function setCity(int $city_id, array $city_data) {

    // }

    // public function setNewCity(array $city_data) {

    // }
}
