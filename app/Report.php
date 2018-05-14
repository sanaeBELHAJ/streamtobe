<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'stb_reports';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'victim_id', 
        'guilty_id', 
        'status',
        'description',
    ];

    /**
     * Report Category
     */
    public function category() 
    {
        return $this->belongsTo('App\ReportCat');
    }
}
