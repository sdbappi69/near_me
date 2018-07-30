<?php

namespace App\Modules\Role\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

    protected $table = 'role_user';

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\Modules\Role\Models\Role', 'role_id', 'id');
    }

}
