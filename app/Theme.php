<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'stb_themes';

    public $timestamps = true;

    /**
     * Get the type list
     * 
     */
    public function types() 
    {
        return $this->hasMany('App\Type');
    }
}
