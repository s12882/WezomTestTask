<?php

namespace App\Services;

use App\Exceptions\ExternalApiException;
use Illuminate\Support\Collection;

class ExternalApiService
{
    /**
     * @return Collection
     * @throws ExternalApiException
     */
    static function getAllManufacturers()
    {
        $json = json_decode(file_get_contents('https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes?format=json'));

        if ($json->Message !== 'Response returned successfully') {
            throw new ExternalApiException(__('External API error occurred'));
        }

        return collect($json->Results);
    }

    /**
     * @param $brandPart
     * @return mixed
     * @throws ExternalApiException
     */
    static function getManufacturer($brandPart)
    {
        return self::getAllManufacturers()->filter(function ($item) use ($brandPart) {
            return false !== stristr($item->Make_Name, $brandPart);
        })->first();
    }

    /**
     * @param int $brandId
     * @return Collection
     * @throws ExternalApiException
     */
    static function getModels(int $brandId)
    {
        $json = json_decode(file_get_contents('https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformakeid/'.$brandId.'?format=json'));

        if ($json->Message !== 'Response returned successfully') {
            throw new ExternalApiException(__('External API error occurred'));
        }

        return collect($json->Results);
    }

    /**
     * @param $number
     * @return array
     */
    static function getCarByVin($number)
    {
        $json = json_decode(file_get_contents('https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/'.$number.'?format=json&model'));

        if (isset($json->Results)) {

            $result = $json->Results;
            return [
                'brand' => $result[6]->Value ?: null,
                'model' => $result[8]->Value ?: null,
                'year' => $result[9]->Value ?: null
            ];
        }

        return [];
    }
}
