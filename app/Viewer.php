<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    protected $table = 'stb_viewers';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'stream_id',
    ];

    /**
     * Stream
     */
    public function stream() 
    {
        return $this->belongsTo('App\Stream');
    }

    /**
     * User
     */
    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get his chat message
     * 
     */
    public function chats() 
    {
        return $this->hasMany('App\Chat');
    }

    /**
     * Get his donations
     * 
     */
    public function donations() 
    {
        return $this->hasMany('App\Invoice');
    }

    /**
     * Get his chat message
     * 
     */
    public function subscribes() 
    {
        return $this->hasMany('App\Subscriber');
    }
}
