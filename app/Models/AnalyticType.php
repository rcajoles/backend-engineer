<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticType extends Model
{
    protected $table = 'analytic_types';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'units',
        'is_numeric',
        'num_decimal_places'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the comments for the blog post.
     */
    public function propertyAnalytic()
    {
        return $this->hasMany('App\Models\PropertyAnalytic', 'analytic_type_id', 'id');
    }
}
