<?php

namespace App\Modules\PrintSale\Models;

use Illuminate\Database\Eloquent\Model;

class PrintSale extends Model {

    public function size()
    {
        return $this->belongsTo('App\Modules\Size\Models\Size', 'size_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Modules\Category\Models\Category', 'category_id', 'id');
    }

}
