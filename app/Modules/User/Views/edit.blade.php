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
		            {!! Form::model($user, array('url' => '/users/'.$user->id, 'method' => 'put', 'enctype' => 'multipart/form-data')) !!}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-xs-6">

		              			<img class="profile-user-img img-responsive img-circle" src="{{ url('/').'/uploads/users/'.$user->image }}" alt="{{ $user->name }}"><br>

		              			<a type="button" data-toggle="modal" data-target="#password" href="javascript:void(0)" class="btn btn-block btn-primary">
				                	<i class="fa fa-key"></i> Change Password
				                </a>

		              			<div class="form-group">
			            			{{ Form::label('image', 'Image') }}
			            			{{ Form::file('image', null, array('class' => 'form-control', 'id' => 'image')) }}
			            			<p class="help-block">Maximum file size: 1 MB</p>
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('name', 'Name') }}
			            			{{ Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('email', 'Email') }}
			            			{{ Form::text('email', null, array('class' => 'form-control', 'id' => 'email', 'required' => 'required')) }}
			            		</div>
		              		</div>

		              		<div class="col-xs-6">
				            		
	              				<table class="table table-striped">
					                <tr>
					                  <th>#</th>
					                  <th>Roles</th>
					                </tr>

					                @if(count($roles) > 0)

					                	@foreach($roles as $role)

					                		<tr>
							                  <td><input type="checkbox" name="roles[]" value="{{ $role->id }}" @if(in_array($role->id, $containing_roles)) checked @endIf></td>
							                  <td>{{ $role->display_name }}</td>
							                </tr>

					                	@endforeach

					                @endIf

					            </table>

		              		</div>

		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		                	<a href="{{ url('users') }}" class="btn btn-default">Cancel</a>
		                	<input type="submit" class="btn btn-info pull-right"  value="Update">
		              	</div>
		              	<!-- /.box-footer -->

		            {!! Form::close() !!}
		        </div>
	        </div>
	    </div>

    </section>

    <div class="modal fade" id="password">
	    <div class="modal-dialog">

	    	{!! Form::model(null, array('url' => '/password/'.$user->id, 'method' => 'put')) !!}

		        <div class="modal-content">
			        <div class="modal-header">
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			              <span aria-hidden="true">&times;</span></button>
			            <h4 class="modal-title">Change Password</h4>
			        </div>
			        <div class="modal-body">
			        	
			        	<div class="form-group">
	            			{{ Form::label('password', 'Password') }}
	            			{{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'required' => 'required', 'pattern' => '.{6,}', 'title' => '6 characters minimum', 'oninput' => 'form.confirm_password.pattern = escapeRegExp(this.value)')) }}
	            		</div>
	            		<div class="form-group">
	            			{{ Form::label('password_confirmation', 'Confirm Password') }}
	            			{{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password_confirmation', 'required' => 'required', 'title' => 'Type the password again')) }}
	            		</div>

			        </div>
			        <div class="modal-footer">
			            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			            <input type="submit" class="btn btn-info pull-right"  value="Update">
			        </div>
		        </div>
		        <!-- /.modal-content -->

	        {!! Form::close() !!}

	    </div>
	    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script type="text/javascript">

		function escapeRegExp(str) {
	      return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	    }

    </script>

@endsection