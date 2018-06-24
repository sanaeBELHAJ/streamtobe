<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'stb_messages';

    public $timestamps = true;

    protected $fillable = [
        'user_first', 
        'user_second', 
        'message', 
        'status',
        'created_at',
    ];

    /**
     * User
     */
    public function user() 
    {
        return $this->belongsTo('App\User');
    }
}
