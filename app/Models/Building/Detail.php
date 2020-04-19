<?php

namespace App\Models\Building;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class Detail extends Model
{
    const RENT_DAILY = "D";
    const RENT_WEEKLY = "W";
    const RENT_MONTHLY = "M";
    const RENT_QUARTERLY = "Q";
    const RENT_YEARLY = "Y";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'building_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_header_id',
        'name',
        'rent_duration',
        'rent_price',
        'created_by',
        'updated_by'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        // Automatically generate slug from title (new or update)
        static::creating(function($model) {
            $model->created_by = !empty(Auth::user()) ? Auth::user()->id : 0;
            $model->updated_by = !empty(Auth::user()) ? Auth::user()->id : 0;
        });

        static::updating(function($model) {
            $model->building_slug = Str::slug($model->building_title);
            $model->updated_by = !empty(Auth::user()) ? Auth::user()->id : 0;
        });
    }

    public function buildingHeader() {
        return $this->belongsTo(Header::class, 'id', 'building_header_id');
    }

    public function buildingAmnesties() {
        return $this->hasMany(Amneties::class, 'building_id', 'id');
    }
}
