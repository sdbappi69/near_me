<?php

namespace App\Modules\Tearsheet\Models;

use Illuminate\Database\Eloquent\Model;

class Tearsheet extends Model {

    public function size()
    {
        return $this->belongsTo('App\Modules\Size\Models\Size', 'size_id', 'id');
    }

}
