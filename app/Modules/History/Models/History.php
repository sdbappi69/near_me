<?php

namespace App\Modules\History\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model {

    protected $table = 'histories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Modules\User\Models\User', 'created_by', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Modules\Type\Models\Type', 'type_id', 'id');
    }

}
