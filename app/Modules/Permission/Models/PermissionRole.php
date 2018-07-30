<?php

namespace App\Modules\Permission\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {

    protected $table = 'permission_role';

    public $timestamps = false;

    public function permission()
    {
        return $this->belongsTo('App\Modules\Permission\Models\Permission', 'permission_id', 'id');
    }

}
