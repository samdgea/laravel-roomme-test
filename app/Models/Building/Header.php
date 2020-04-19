<?php

namespace App\Models\Building;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Header extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'building_header';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_title',
        'building_slug',
        'building_address',
        'building_desc',
        'building_lat_coordinate',
        'building_long_coordinate',
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
            $model->building_slug = Str::slug($model->building_title);
            $model->created_by = !empty(Auth::user()) ? Auth::user()->id : 0;
            $model->updated_by = !empty(Auth::user()) ? Auth::user()->id : 0;
        });

        static::updating(function($model) {
            $model->building_slug = Str::slug($model->building_title);
            $model->updated_by = !empty(Auth::user()) ? Auth::user()->id : 0;
        });
    }

    public function buildingChilds()
    {
        return $this->hasMany(Detail::class, 'building_header_id', 'id');
    }

}
