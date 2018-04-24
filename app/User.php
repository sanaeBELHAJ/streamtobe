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
        'pseudo', 
        'email', 
        'password',
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
    public function setPathPicture($path){
        return str_replace('public/','',$path);
    }
}
