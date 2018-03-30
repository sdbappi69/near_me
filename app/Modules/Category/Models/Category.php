<?php

namespace App\Modules\Category\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    public function photos()
    {
        return $this->hasMany('App\Modules\Photo\Models\PhotoCategory', 'category_id', 'id')->orderBy('priority', 'asc');
    }

}
