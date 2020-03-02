<li class="nav dashboard active"><a href="{{ url('panel/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


<li class="header">User Management</li>
@permission('user-view')
  <li class="treeview nav users">
      <a href="#">
        <i class="fa fa-users"></i> <span>Users</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('user-create')
          <li class="nav users-add"><a href="{{ url('panel/users/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav users-manage"><a href="{{ url('panel/users') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('role-view')
  <li class="treeview nav roles">
      <a href="#">
        <i class="fa fa-user"></i> <span>Roles</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('role-create')
          <li class="nav roles-add"><a href="{{ url('panel/roles/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav roles-manage"><a href="{{ url('panel/roles') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('permission-view')
  <li class="treeview nav permissions">
      <a href="#">
        <i class="fa fa-unlock"></i> <span>Permissions</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('permission-create')
          <li class="nav permissions-add"><a href="{{ url('panel/permissions/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav permissions-manage"><a href="{{ url('panel/permissions') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission