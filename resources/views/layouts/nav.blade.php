<li class="nav dashboard active"><a href="{{ url('panel/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


<li class="header">Content Management</li>
@permission('photo-view')
  <li class="treeview nav photos">
      <a href="#">
        <i class="fa fa-picture-o"></i> <span>Photos</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('photo-create')
          <li class="nav photos-add"><a href="{{ url('panel/photos/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav photos-manage"><a href="{{ url('panel/photos') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('biography-view')
  <li class="treeview nav biographies">
      <a href="#">
        <i class="fa fa-file-text"></i> <span>Biography</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('biography-create')
          <li class="nav biographies-add"><a href="{{ url('panel/biographies/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav biographies-manage"><a href="{{ url('panel/biographies') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('award-view')
  <li class="treeview nav awards">
      <a href="#">
        <i class="fa fa-angellist"></i> <span>Awards</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('award-create')
          <li class="nav awards-add"><a href="{{ url('panel/awards/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav awards-manage"><a href="{{ url('panel/awards') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('testimonial-view')
  <li class="treeview nav testimonials">
      <a href="#">
        <i class="fa fa-certificate"></i> <span>Testimonials</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('testimonial-create')
          <li class="nav testimonials-add"><a href="{{ url('panel/testimonials/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav testimonials-manage"><a href="{{ url('panel/testimonials') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('book-view')
  <li class="treeview nav books">
      <a href="#">
        <i class="fa fa-book"></i> <span>Books</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('book-create')
          <li class="nav books-add"><a href="{{ url('panel/books/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav books-manage"><a href="{{ url('panel/books') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('video-view')
<li class="treeview nav videos">
    <a href="#">
      <i class="fa fa-video-camera"></i> <span>Videos</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      @permission('video-create')
        <li class="nav videos-add"><a href="{{ url('panel/videos/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      @endpermission
      <li class="nav videos-manage"><a href="{{ url('panel/videos') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
@endpermission



<li class="header">Sale Management</li>
@permission('printsell-view')
  <li class="treeview nav print-sales">
      <a href="#">
        <i class="fa fa-barcode"></i> <span>Print Sell</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('printsell-create')
          <li class="nav print-sales-add"><a href="{{ url('panel/print-sales/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav print-sales-manage"><a href="{{ url('panel/print-sales') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
        @permission('orderprintsell-view')
          <li class="nav print-sales-order"><a href="{{ url('panel/order-print-sales') }}"><i class="fa fa-cart-plus"></i> Orders</a></li>
        @endpermission
      </ul>
  </li>
@endpermission
@permission('sell-view')
<li class="treeview nav sales">
    <a href="#">
      <i class="fa fa-shopping-cart"></i> <span>Sell</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      @permission('sell-create')
        <li class="nav sales-add"><a href="{{ url('panel/sales/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      @endpermission
      <li class="nav sales-manage"><a href="{{ url('panel/sales') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      @permission('ordersell-view')
        <li class="nav sales-order"><a href="{{ url('panel/order-sales') }}"><i class="fa fa-cart-plus"></i> Orders</a></li>
      @endpermission
    </ul>
</li>
@endpermission
@permission('tearsheet-view')
<li class="treeview nav tearsheets">
    <a href="#">
      <i class="fa fa-file-photo-o"></i> <span>Tearsheets</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      @permission('tearsheet-create')
        <li class="nav tearsheets-add"><a href="{{ url('panel/tearsheets/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      @endpermission
      <li class="nav tearsheets-manage"><a href="{{ url('panel/tearsheets') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      @permission('ordertearsheet-view')
        <li class="nav tearsheets-order"><a href="{{ url('panel/order-tearsheets') }}"><i class="fa fa-cart-plus"></i> Orders</a></li>
      @endpermission
    </ul>
</li>
@endpermission



<li class="header">Photo Settings</li>
@permission('size-view')
  <li class="treeview nav sizes">
      <a href="#">
        <i class="fa fa-object-ungroup"></i> <span>Sizes</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('size-create')
          <li class="nav sizes-add"><a href="{{ url('panel/sizes/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav sizes-manage"><a href="{{ url('panel/sizes') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('category-view')
  <li class="treeview nav categories">
      <a href="#">
        <i class="fa fa-clone"></i> <span>Categories</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('category-create')
          <li class="nav categories-add"><a href="{{ url('panel/categories/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav categories-manage"><a href="{{ url('panel/categories') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('album-view')
  <li class="treeview nav albums">
      <a href="#">
        <i class="fa fa-folder-open"></i> <span>Albums</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('album-create')
          <li class="nav albums-add"><a href="{{ url('panel/albums/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav albums-manage"><a href="{{ url('panel/albums') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission



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



<li class="header">Site Settings</li>
@permission('slider-view')
  <li class="treeview nav sliders">
      <a href="#">
        <i class="fa fa-map"></i> <span>Sliders</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('slider-create')
          <li class="nav sliders-add"><a href="{{ url('panel/sliders/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav sliders-manage"><a href="{{ url('panel/sliders') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('theme-view')
  <li class="treeview nav themes">
      <a href="#">
        <i class="fa fa-sun-o"></i> <span>Themes</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('theme-create')
          <li class="nav themes-add"><a href="{{ url('panel/themes/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav themes-manage"><a href="{{ url('panel/themes') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('social-view')
  <li class="treeview nav socials">
      <a href="#">
        <i class="fa fa-share-alt"></i> <span>Social Networks</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission('social-create')
          <li class="nav socials-add"><a href="{{ url('panel/socials/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
        @endpermission
        <li class="nav socials-manage"><a href="{{ url('panel/socials') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
      </ul>
  </li>
@endpermission
@permission('setting')
  <li class="nav settings"><a href="{{ url('panel/settings') }}"><i class="fa fa-cog"></i> <span>Setting</span></a></li>
@endpermission