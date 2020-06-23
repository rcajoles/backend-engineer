<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    protected $table = 'properties';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guid',
        'suburb',
        'state',
        'country'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];

    /**
     *  Setup model event hooks
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->guid = (string) Str::uuid();
        });
    }

    /**
     * Get the PropertyAnalytic for the Property.
     */
    public function propertyAnalytic()
    {
        return $this->hasMany('App\Models\PropertyAnalytic');
    }
}
