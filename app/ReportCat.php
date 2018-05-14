<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCat extends Model
{
    protected $table = 'stb_reports_category';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the reports list
     * 
     */
    public function reports() 
    {
        return $this->hasMany('App\Report');
    }
}
