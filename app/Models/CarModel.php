<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CarModel
 * @package App\Models
 * @property integer $id
 * @property Brand $brand
 * @property string $name
 * @mixin Eloquent
 */
class CarModel extends Model
{
    /**
     * @return BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
