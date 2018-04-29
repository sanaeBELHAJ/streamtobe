<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $table = 'stb_streams';

    public $timestamps = true;

    protected $fillable = [
        'titre',
        'streamer_id',
        'status',
    ];

    /**
     * Stream owner : user
     */
    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Stream type
     */
    public function type() 
    {
        return $this->belongsTo('App\Type');
    }
}
