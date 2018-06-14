<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'title', 
        'price', 
        'message', 
        'viewer_id', 
        'payment_status',
        'recurring_id'
    ];

    public function getPaidAttribute() {
    	if ($this->payment_status == 'Invalid') {
    		return false;
    	}
    	return true;
    }
}
