<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'stb_chats';

    public $timestamps = true;

    protected $fillable = [
        'message',
        'stream_id',
        'user_id',
        'status',
    ];

    /**
     * Stream owner
     */
    public function stream() 
    {
        return $this->belongsTo('App\Stream');
    }

    /**
     * User writer
     */
    public function user() 
    {
        return $this->belongsTo('App\User');
    }
}
