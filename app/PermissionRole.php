<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {

    protected $table = 'permission_role';

    public $timestamps = false;

    public function permission()
    {
        return $this->belongsTo('App\Permission', 'permission_id', 'id');
    }

}
