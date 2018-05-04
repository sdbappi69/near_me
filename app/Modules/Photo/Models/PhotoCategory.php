<?php

namespace App\Modules\Photo\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoCategory extends Model {

    protected $table = 'photo_category';

    public $timestamps = false;

    public function photo()
    {
        return $this->belongsTo('App\Modules\Photo\Models\Photo', 'photo_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Modules\Category\Models\Category', 'category_id', 'id');
    }

}
