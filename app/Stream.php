<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $table = 'streams';

    public $timestamps = true;

    protected $fillable = [
        'titre',
        'streamer_id'
    ];

    /**
     * Stream owner : user
     */
    public function user() 
    {
        return $this->belongsTo('App\User');
    }
}
