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
		            {{ Form::open(array('url' => 'panel/socials', 'enctype' => 'multipart/form-data')) }}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', Input::old('name'), array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Name')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('font_awesome', 'Font Awesome') }}
			            			{{ Form::text('font_awesome', Input::old('font_awesome'), array('class' => 'form-control input-lg', 'placeholder' => 'ex: fa-facebook')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('status', 'Status*') }}
			            			{!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], Input::old('status'), ['class' => 'form-control input-lg', 'required' => 'required']) !!}
			            		</div>
		              		</div>

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('url', 'URL') }}
			            			{{ Form::text('url', Input::old('url'), array('class' => 'form-control input-lg', 'placeholder' => 'URL', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('size_id', 'Full image size*') }}
			            			{!! Form::select('size_id', $sizes, $default_size->id, ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'size_id', 'required' => 'required']) !!}
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
        	page_select('socials-add', 'socials', 'Social networks', 'Add');
		});

    </script>

@endsection