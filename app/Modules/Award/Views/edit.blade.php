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
		            {!! Form::model($award, array('url' => 'panel/awards/'.$award->id, 'method' => 'put', 'enctype' => 'multipart/form-data')) !!}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-xs-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Name')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('description', 'Description') }}
			            			{{ Form::textarea('description', null, array('class' => 'form-control input-lg textarea', 'placeholder' => 'Description', 'rows' => '10')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('date', 'Date') }}
			            			<div class="input-group">
					                  	<div class="input-group-addon">
					                    	<i class="fa fa-calendar"></i>
					                  	</div>
					                  	{{ Form::text('date', null, array('class' => 'form-control input-lg', 'id' => 'datepicker', 'placeholder' => 'Date', 'data-date-format' => 'yyyy-mm-dd')) }}
					                </div>
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('status', 'Status*') }}
			            			{!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], null, ['class' => 'form-control input-lg', 'required' => 'required']) !!}
			            		</div>
		              		</div>

		              		<div class="col-xs-6">
		              			<div class="form-group">
			            			{{ Form::label('url', 'URL') }}
			            			{{ Form::text('url', null, array('class' => 'form-control input-lg', 'placeholder' => 'URL')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('video_url', 'Video URL') }}
			            			{{ Form::text('video_url', null, array('class' => 'form-control input-lg', 'placeholder' => 'Video URL')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('social_url', 'Social link') }}
			            			{{ Form::text('social_url', null, array('class' => 'form-control input-lg', 'placeholder' => 'Social link')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('youtube', 'Youtube video code') }}
			            			{{ Form::text('youtube', null, array('class' => 'form-control input-lg', 'placeholder' => 'Youtube video code')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('thumbnail_size_id', 'Thumbnail image size*') }}
			            			{!! Form::select('thumbnail_size_id', $sizes, null, ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'thumbnail_size_id', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('size_id', 'Full image size*') }}
			            			{!! Form::select('size_id', $sizes, null, ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'size_id', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('iamge', 'Image') }}
			            			{{ Form::file('image', null, array('class' => 'form-control input-lg', 'id' => 'image')) }}
			            			<p class="help-block">Maximum file size: 2 MB</p>
			            		</div>
		              		</div>

		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		              		<a href="{{ url('panel/awards') }}" class="btn btn-default">Cancel</a>
		                	<input type="submit" class="btn btn-info pull-right"  value="Update">
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
        	page_select('awards-manage', 'awards', 'Awards', 'update');
		});

    </script>

@endsection