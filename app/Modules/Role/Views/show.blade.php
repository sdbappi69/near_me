@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row">
	        <div class="col-xs-12 animated bounceInDown">
	    		<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title">Role</h3>
		            </div>
		            <!-- /.box-header -->

	              	<div class="box-body">

	              		<div class="col-xs-6">

	              			<table class="table table-striped">

				                <tr>
				                  <th>Display Name</th>
				                  <td>{{ $role->display_name }}</td>
				                </tr>

				                <tr>
				                  <th>Name</th>
				                  <td>{{ $role->name }}</td>
				                </tr>

				                <tr>
				                  <th>Description</th>
				                  <td>{{ $role->description }}</td>
				                </tr>

				            </table>

				        </div>

	              		<div class="col-xs-6">
			            		
              				<table class="table table-striped">
				                <tr>
				                  <th>#</th>
				                  <th>Permissions</th>
				                </tr>

				                @if(count($role->permissions) > 0)

				                	@foreach($role->permissions as $data)

				                		<tr>
						                  <td><i class="fa fa-check"></i></td>
						                  <td>{{ $data->permission->display_name }}</td>
						                </tr>

				                	@endforeach

				                @endIf

				            </table>

	              		</div>

	              	</div>
		        </div>
	        </div>
	    </div>

    </section>

    <script type="text/javascript">

    </script>

@endsection