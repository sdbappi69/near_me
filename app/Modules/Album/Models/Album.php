<?php

namespace App\Modules\Album\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model {

    public function photos()
    {
        return $this->hasMany('App\Modules\Photo\Models\PhotoAlbum', 'album_id', 'id')->orderBy('priority', 'asc');
    }

}
