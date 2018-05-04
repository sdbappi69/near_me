<?php

namespace App\Modules\Photo\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoAlbum extends Model {

    protected $table = 'photo_album';

    public $timestamps = false;

    public function photo()
    {
        return $this->belongsTo('App\Modules\Photo\Models\Photo', 'photo_id', 'id');
    }

    public function album()
    {
        return $this->belongsTo('App\Modules\Album\Models\Album', 'album_id', 'id');
    }

}
