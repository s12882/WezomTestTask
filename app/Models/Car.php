<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 * @package App\Models
 * @mixin Eloquent
 */
class Car extends Model
{
    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 5;

    protected $fillable = [
        'name', 'gov_number', 'color', 'vin_code', 'brand', 'model', 'year'
    ];
}
