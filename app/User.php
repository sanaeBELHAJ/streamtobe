<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;
    
    protected $table = 'users';

    public $timestamps = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'pseudo', 
        'email', 
        'password',
        'id_countries',
        'description',
        'status',
        'confirmation_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    /**
     * Remove the path 'public/' from the data table User
     * 
     */
    public function setPathAvatar($path){
        return str_replace('public/','',$path);
    }

    /**
     * Get his stream list
     * 
     */
    public function stream() 
    {
        return $this->hasOne('App\Stream','streamer_id');
    }
     /**
     * Get his stream list
     * 
     */
    public function country() 
    {
        return $this->hasOne('App\Countries','id');
    }
    /**
     * Get his chat message
     * 
     */
    public function viewers() 
    {
        return $this->hasMany('App\Viewer');
    }

    /**
     * Get his messages
     * 
     */
    public function messages() 
    {
        return $this->hasMany('App\Message');
    }
}
