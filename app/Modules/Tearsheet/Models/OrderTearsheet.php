<?php

namespace App\Modules\Tearsheet\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTearsheet extends Model {

    protected $table = 'orders_tearsheets';

    public $timestamps = false;

    public function photo()
    {
        return $this->belongsTo('App\Modules\Tearsheet\Models\Tearsheet', 'tearsheet_id', 'id');
    }

}
