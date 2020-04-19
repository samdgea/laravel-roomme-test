<?php

namespace App\Models\Building;

use App\Models\Master\Amneties as MasterAmneties;
use Illuminate\Database\Eloquent\Model;

class Amneties extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'building_has_amneties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_id', 'amneties_id'
    ];

    public function buildingDetail()
    {
        return $this->belongsTo(Detail::class, 'id', 'building_id');
    }

    public function amnetiesDetail()
    {
        return $this->belongsTo(MasterAmneties::class, 'id', 'amneties_id');
    }
}