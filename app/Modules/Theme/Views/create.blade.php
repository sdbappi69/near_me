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
		            {{ Form::open(array('url' => 'panel/themes', 'enctype' => 'multipart/form-data')) }}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', Input::old('name'), array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Name')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('description', 'Description') }}
			            			{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control input-lg', 'placeholder' => 'Description')) }}
			            		</div>
		              		</div>

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('folder', 'Folder*') }}
			            			{{ Form::text('folder', Input::old('folder'), array('class' => 'form-control input-lg', 'placeholder' => 'Folder', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('status', 'Status*') }}
			            			{!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], Input::old('status'), ['class' => 'form-control input-lg', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('iamge', 'Image*') }}
			            			{{ Form::file('image', Input::old('image'), array('class' => 'form-control input-lg', 'id' => 'image', 'required' => 'required')) }}
			            			<p class="help-block">Maximum file size: 2 MB</p>
			            		</div>
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
    	
    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('themes-add', 'themes', 'Themes', 'Add');
		});

    </script>

@endsection