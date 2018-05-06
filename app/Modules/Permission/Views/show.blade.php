@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row">
	        <div class="col-xs-12 animated bounceInDown">
	    		<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title">Permission</h3>
		            </div>
		            <!-- /.box-header -->

	              	<div class="box-body">

              			<table class="table table-striped">

			                <tr>
			                  <th>Display Name</th>
			                  <td>{{ $permission->display_name }}</td>
			                </tr>

			                <tr>
			                  <th>Name</th>
			                  <td>{{ $permission->name }}</td>
			                </tr>

			                <tr>
			                  <th>Description</th>
			                  <td>{{ $permission->description }}</td>
			                </tr>

			            </table>

	              	</div>
		        </div>
	        </div>
	    </div>

    </section>

    <script type="text/javascript">

    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('permissions-manage', 'permissions', 'Permissions', 'Add');
		});

    </script>

@endsection