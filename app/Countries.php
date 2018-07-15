<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{

    protected $table = 'stb_countries';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code', 
        'name', 
        'svg',
    ];

    /**
     * Get the users
     * 
     */
    public function users() 
    {
        return $this->hasMany('App\User');
    }
}
