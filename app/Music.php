<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'stb_musics';

    public $timestamps = true;

    protected $fillable = [
        'title', 
        'mark',
        'qtty_votes', 
        'status', 
        'gift_viewer',
        'stream_id'
    ];

    /**
     * User
     */
    public function stream() 
    {
        return $this->belongsTo('App\Stream');
    }
}
