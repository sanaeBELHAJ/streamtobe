<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'stb_invoices';

    protected $fillable = [
        'paypal_id', 
        'paypal_cart', 
        'amount', 
        'currency', 
        'country', 
        'city', 
        'message', 
        'paypal_payer_id', 
        'viewer_id', 
        'status',
        'created_at',
    ];

    /**
     * Viewer writer
     */
    public function viewer() 
    {
        return $this->belongsTo('App\Viewer');
    }
}
