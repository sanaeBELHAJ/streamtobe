<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $table = 'stb_bans';

    public $timestamps = true;

    protected $fillable = [
        'user_ban',
        'user_banned'
    ];

    /**
     * Viewer writer
     */
    public function user() 
    {
        return $this->belongsTo('App\User');
    }
}
