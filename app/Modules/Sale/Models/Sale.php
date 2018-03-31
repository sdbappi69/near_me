<?php

namespace App\Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

    public function size()
    {
        return $this->belongsTo('App\Modules\Size\Models\Size', 'size_id', 'id');
    }

}
