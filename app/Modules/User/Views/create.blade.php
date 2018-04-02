@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row">
	        <div class="col-xs-12 animated bounceInDown">
	    		<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title">Create</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            {{ Form::open(array('url' => 'users', 'enctype' => 'multipart/form-data')) }}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('image', 'Image') }}
			            			{{ Form::file('image', Input::old('image'), array('class' => 'form-control', 'id' => 'image')) }}
			            			<p class="help-block">Maximum file size: 1 MB</p>
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('name', 'Name') }}
			            			{{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'id' => 'name', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('email', 'Email') }}
			            			{{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'id' => 'email', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('password', 'Password') }}
			            			{{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'required' => 'required', 'pattern' => '.{6,}', 'title' => '6 characters minimum', 'oninput' => 'form.confirm_password.pattern = escapeRegExp(this.value)')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('password_confirmation', 'Confirm Password') }}
			            			{{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password_confirmation', 'required' => 'required', 'title' => 'Type the password again')) }}
			            		</div>
		              		</div>

		              		<div class="col-md-6">
				            		
	              				<table class="table table-striped">
					                <tr>
					                  <th>#</th>
					                  <th>Roles</th>
					                </tr>

					                @if(count($roles) > 0)

					                	@foreach($roles as $role)

					                		<tr>
							                  <td><input type="checkbox" name="roles[]" value="{{ $role->id }}"></td>
							                  <td>{{ $role->display_name }}</td>
							                </tr>

					                	@endforeach

					                @endIf

					            </table>

		              		</div>

		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		                	<input type="reset" class="btn btn-default" value="Reset">
		                	<input type="submit" class="btn btn-info pull-right"  value="Create">
		              	</div>
		              	<!-- /.box-footer -->

		            {!! Form::close() !!}
		        </div>
	        </div>
	    </div>

    </section>

    <script type="text/javascript">

		function escapeRegExp(str) {
	      return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	    }

    </script>

@endsection