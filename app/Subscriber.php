<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'stb_subscribers';

    public $timestamps = true;

    protected $fillable = [
        'viewer_id',
        'status',
        'amount',
        'renewable',
    ];

    /**
     * Viewer customer
     */
    public function viewer() 
    {
        return $this->belongsTo('App\Viewer');
    }
}
