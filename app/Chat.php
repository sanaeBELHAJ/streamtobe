<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'stb_chats';

    public $timestamps = true;

    protected $fillable = [
        'message',
        'viewer_id',
        'status',
    ];

    /**
     * Viewer writer
     */
    public function viewer() 
    {
        return $this->belongsTo('App\Viewer');
    }
}
