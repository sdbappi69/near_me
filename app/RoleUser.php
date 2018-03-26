<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

    protected $table = 'role_user';

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

}
