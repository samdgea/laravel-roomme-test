<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Amneties extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'building_amneties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amneties_name', 'amneties_logo_image'
    ];
}
