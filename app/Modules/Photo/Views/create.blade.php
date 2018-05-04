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
		            {{ Form::open(array('url' => 'panel/photos', 'enctype' => 'multipart/form-data')) }}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', Input::old('name'), array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Name')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('product_id', 'Product id') }}
			            			{{ Form::text('product_id', Input::old('product_id'), array('class' => 'form-control input-lg', 'placeholder' => 'Product id')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('price', 'Price') }}
			            			{{ Form::text('price', Input::old('price'), array('class' => 'form-control input-lg', 'placeholder' => 'Price')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('description', 'Description') }}
			            			{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control input-lg', 'placeholder' => 'Description', 'rows' => '7')) }}
			            		</div>
		              		</div>

		              		<div class="col-md-6">
			            		<div class="form-group">
			            			{{ Form::label('thumbnail_size_id', 'Thumbnail image size*') }}
			            			{!! Form::select('thumbnail_size_id', ['' => 'Select image size']+$sizes, $default_size_id, ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'thumbnail_size_id', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('size_id', 'Full image size*') }}
			            			{!! Form::select('size_id', ['' => 'Select image size']+$sizes, $default_size_id, ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'size_id', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('iamges', 'Images*') }}
			            			<input class="" type="file" name="images[]" multiple="multiple">
			            			<p class="help-block">Maximum size: 5 MB</p>
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('album_ids', 'Albums*') }}
			            			{!! Form::select('album_ids[]', $albums, $default_album_id, ['class' => 'form-control js-example-basic-single input-lg select2', 'id' => 'album_ids', 'multiple' => 'multiple', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('category_ids', 'Categories*') }}
			            			{!! Form::select('category_ids[]', $categories, $default_category_id, ['class' => 'form-control js-example-basic-single input-lg select2', 'id' => 'category_ids', 'multiple' => 'multiple', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('status', 'Status*') }}
			            			{!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], Input::old('status'), ['class' => 'form-control input-lg', 'required' => 'required']) !!}
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
        	page_select('photos-add', 'photos', 'Photos', 'Add');
		});

    </script>

@endsection