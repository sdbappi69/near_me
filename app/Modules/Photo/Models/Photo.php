<?php

namespace App\Modules\Photo\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

	public function size()
    {
        return $this->belongsTo('App\Modules\Size\Models\Size', 'size_id', 'id');
    }

    public function albums()
    {
        return $this->hasMany('App\Modules\Photo\Models\PhotoAlbum', 'photo_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany('App\Modules\Photo\Models\PhotoCategory', 'photo_id', 'id');
    }

}
