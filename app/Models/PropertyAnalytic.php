<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAnalytic extends Model
{
    protected $table = 'property_analytics';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'analytic_type_id',
        'value'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the post that owns the comment.
     */
    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

    /**
     * Get the post that owns the comment.
     */
    public function analytic()
    {
        return $this->belongsTo('App\Models\AnalyticType', 'analytic_type_id');
    }
}
