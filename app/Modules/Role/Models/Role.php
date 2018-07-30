<?php

namespace App\Modules\Role\Models;

use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Role extends EntrustRole {

	use EntrustUserTrait;

	protected $table = 'roles';

    public function permissions()
    {
        return $this->hasMany('App\Modules\Permission\Models\PermissionRole');
    }

}
