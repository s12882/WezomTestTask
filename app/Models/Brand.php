<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Brand
 * @property integer $id
 * @property string $name
 * @package App\Models
 * @mixin \Eloquent
 */
class Brand extends Model
{
    /**
     * @return HasMany
     */
    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }
}
