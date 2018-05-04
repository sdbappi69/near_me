<?php

namespace App\Modules\PrintSale\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPrintSale extends Model {

    protected $table = 'orders_print_sales';

    public $timestamps = false;

    public function photo()
    {
        return $this->belongsTo('App\Modules\PrintSale\Models\PrintSale', 'print_sale_id', 'id');
    }

}
