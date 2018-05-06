@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row">

	        <div class="col-xs-4 animated bounceInLeft">
	    		<div class="box box-primary">
		            <div class="box-header with-border">
		              <h3 class="box-title">User</h3>
		            </div>
		            <!-- /.box-header -->

	              	<div class="box-body box-profile">

	              		<!-- if there are creation errors, they will show here -->
						@include('partials.errors')

              			<img class="profile-user-img img-responsive img-circle" src="{{ url('/').'/uploads/users/'.$user->image }}" alt="{{ $user->name }}">

              			<h3 class="profile-username text-center">{{ $user->name }}</h3>

          				<p class="text-muted text-center">{{ $user->email }}</p>

          				<a href="{{ url('panel/profile/'.$user->id.'/edit') }}" class="btn btn-block btn-primary">
		                	<i class="fa fa-pencil"></i> Update
		                </a>

		                <a type="button" data-toggle="modal" data-target="#password" href="javascript:void(0)" class="btn btn-block btn-primary">
		                	<i class="fa fa-key"></i> Change Password
		                </a>

	              	</div>
		        </div>
	        </div>

	        <div class="col-xs-8 animated bounceInRight">
	    		<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title">Roles</h3>
		            </div>
		            <!-- /.box-header -->

	              	<div class="box-body">
			            		
          				<table class="table table-striped">
			                <tr>
			                  <th>#</th>
			                  <th>Roles</th>
			                </tr>

			                @if(count($user->roles) > 0)

			                	@foreach($user->roles as $data)

			                		<tr>
					                  <td><i class="fa fa-check"></i></td>
					                  <td>{{ $data->role->display_name }}</td>
					                </tr>

			                	@endforeach

			                @endIf

			            </table>

	              	</div>
		        </div>
	        </div>

	    </div>

    </section>

    <div class="modal fade" id="password">
	    <div class="modal-dialog">

	    	{!! Form::model(null, array('url' => 'panel/profile-password/'.$user->id, 'method' => 'put')) !!}

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