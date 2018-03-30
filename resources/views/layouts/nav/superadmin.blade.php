<li class="nav dashboard active"><a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>



<li class="header">Content Management</li>
<li class="treeview nav photos">
    <a href="#">
      <i class="fa fa-picture-o"></i> <span>Photos</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav photos-add"><a href="{{ url('photos/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav photos-manage"><a href="{{ url('photos') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav biographies">
    <a href="#">
      <i class="fa fa-file-text"></i> <span>Biography</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav biographies-add"><a href="{{ url('biographies/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav biographies-manage"><a href="{{ url('biographies') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav awards">
    <a href="#">
      <i class="fa fa-angellist"></i> <span>Awards</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav awards-add"><a href="{{ url('awards/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav awards-manage"><a href="{{ url('awards') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav testimonials">
    <a href="#">
      <i class="fa fa-certificate"></i> <span>Testimonials</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav testimonials-add"><a href="{{ url('testimonials/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav testimonials-manage"><a href="{{ url('testimonials') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav books">
    <a href="#">
      <i class="fa fa-book"></i> <span>Books</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav books-add"><a href="{{ url('books/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav books-manage"><a href="{{ url('books') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav videos">
    <a href="#">
      <i class="fa fa-video-camera"></i> <span>Videos</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav videos-add"><a href="{{ url('videos/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav videos-manage"><a href="{{ url('videos') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>



<li class="header">Sale Management</li>
<li class="treeview nav print-sale">
    <a href="#">
      <i class="fa fa-barcode"></i> <span>Print Sales</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav print-sale-add"><a href="{{ url('print-sale/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav print-sale-manage"><a href="{{ url('print-sale') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav sales">
    <a href="#">
      <i class="fa fa-shopping-cart"></i> <span>Sales</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav sales-add"><a href="{{ url('sales/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav sales-manage"><a href="{{ url('sales') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav tearsheets">
    <a href="#">
      <i class="fa fa-file-photo-o"></i> <span>Tearsheets</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav tearsheets-add"><a href="{{ url('tearsheets/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav tearsheets-manage"><a href="{{ url('tearsheets') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>



<li class="header">Photo Settings</li>
<li class="treeview nav sizes">
    <a href="#">
      <i class="fa fa-object-ungroup"></i> <span>Sizes</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav sizes-add"><a href="{{ url('sizes/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav sizes-manage"><a href="{{ url('sizes') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav categories">
    <a href="#">
      <i class="fa fa-clone"></i> <span>Categories</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav categories-add"><a href="{{ url('categories/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav categories-manage"><a href="{{ url('categories') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav albums">
    <a href="#">
      <i class="fa fa-folder-open"></i> <span>Albums</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav albums-add"><a href="{{ url('albums/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav albums-manage"><a href="{{ url('albums') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>



<!-- <li class="header">User Management</li>
<li class="treeview nav users">
    <a href="#">
      <i class="fa fa-users"></i> <span>Users</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav users-add"><a href="{{ url('users/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav users-manage"><a href="{{ url('users') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav roles">
    <a href="#">
      <i class="fa fa-user"></i> <span>Roles</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav roles-add"><a href="{{ url('roles/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav roles-manage"><a href="{{ url('roles') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav permissions">
    <a href="#">
      <i class="fa fa-unlock"></i> <span>Permissions</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav permissions-add"><a href="{{ url('permissions/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav permissions-manage"><a href="{{ url('permissions') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li> -->



<li class="header">Site Settings</li>
<li class="treeview nav slider">
    <a href="#">
      <i class="fa fa-map"></i> <span>Sliders</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav slider-add"><a href="{{ url('slider/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav slider-manage"><a href="{{ url('slider') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav themes">
    <a href="#">
      <i class="fa fa-sun-o"></i> <span>Themes</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav themes-add"><a href="{{ url('themes/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav themes-manage"><a href="{{ url('themes') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="treeview nav social">
    <a href="#">
      <i class="fa fa-share-alt"></i> <span>Social Networks</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="nav social-add"><a href="{{ url('social/create') }}"><i class="fa fa-plus"></i> Add new</a></li>
      <li class="nav social-manage"><a href="{{ url('social') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
    </ul>
</li>
<li class="nav setting"><a href="{{ url('setting') }}"><i class="fa fa-cog"></i> <span>Setting</span></a></li>