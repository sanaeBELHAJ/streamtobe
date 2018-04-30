<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'stb_types';

    public $timestamps = true;

    /**
     * Theme stream
     */
    public function theme() 
    {
        return $this->belongsTo('App\Theme');
    }

    /**
     * Get the stream list
     * 
     */
    public function streams() 
    {
        return $this->hasMany('App\Stream');
    }
}
