<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
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
}
