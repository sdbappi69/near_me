<?php

namespace App\Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSale extends Model {

    protected $table = 'orders_sales';

    public $timestamps = false;

    public function photo()
    {
        return $this->belongsTo('App\Modules\Sale\Models\Sale', 'sale_id', 'id');
    }

}
