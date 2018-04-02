@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row">
	        <div class="col-xs-12 animated bounceInDown">
	    		<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title">Edit</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            {!! Form::model($role, array('url' => '/roles/'.$role->id, 'method' => 'put')) !!}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('display_name', 'Display Name') }}
			            			{{ Form::text('display_name', null, array('class' => 'form-control', 'id' => 'display_name', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('name', 'Name') }}
			            			{{ Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('description', 'Description') }}
			            			{{ Form::text('description', null, array('class' => 'form-control')) }}
			            		</div>
		              		</div>

		              		<div class="col-md-6">
				            		
	              				<table class="table table-striped">
					                <tr>
					                  <th>#</th>
					                  <th>Permissions</th>
					                </tr>

					                @if(count($permissions) > 0)

					                	@foreach($permissions as $permission)

					                		<tr>
							                  <td><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @if(in_array($permission->id, $containing_permissions)) checked @endIf></td>
							                  <td>{{ $permission->display_name }}</td>
							                </tr>

					                	@endforeach

					                @endIf

					            </table>

		              		</div>

		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		                	<a href="{{ url('roles') }}" class="btn btn-default">Cancel</a>
		                	<input type="submit" class="btn btn-info pull-right"  value="Update">
		              	</div>
		              	<!-- /.box-footer -->

		            {!! Form::close() !!}
		        </div>
	        </div>
	    </div>

    </section>

    <script type="text/javascript">

    </script>

@endsection