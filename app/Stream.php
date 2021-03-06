<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $table = 'stb_streams';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'title',
        'streamer_id',
        'type_id',
        'status',
    ];

    /**
     * Stream owner : user
     */
    public function user() 
    {
        return $this->belongsTo('App\User','streamer_id');
    }

    /**
     * Stream type
     */
    public function type() 
    {
        return $this->belongsTo('App\Type');
    }

    /**
     * Get his chat message
     * 
     */
    public function viewers() 
    {
        return $this->hasMany('App\Viewer');
    }
}
