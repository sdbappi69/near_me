@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row">
	        <div class="col-xs-12 animated bounceInDown">
	    		<div class="box box-success">
		            <!-- form start -->
		            {{ Form::open(array('url' => 'panel/settings', 'enctype' => 'multipart/form-data')) }}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', $setting->name, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Name')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('sub_title', 'Sub Title') }}
			            			{{ Form::text('sub_title', $setting->sub_title, array('class' => 'form-control input-lg', 'placeholder' => 'Sub Title')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('email', 'Email*') }}
			            			{{ Form::email('email', $setting->email, array('class' => 'form-control input-lg', 'placeholder' => 'Email', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('phone', 'Phone Number*') }}
			            			{{ Form::text('phone', $setting->phone, array('class' => 'form-control input-lg', 'placeholder' => 'Phone Number')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('size_id', 'Logo image size*') }}
			            			{!! Form::select('size_id', $sizes, $setting->size_id, ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'size_id', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('iamge', 'Logo') }}
			            			{{ Form::file('image', null, array('class' => 'form-control input-lg', 'id' => 'image')) }}
			            			<p class="help-block">Maximum file size: 2 MB</p>
			            		</div>
			            		<img src="{{ url('uploads/photos/full/').'/'.$setting->image }}" alt="{{ $setting->name }}" style="max-width: 100%;">
		              		</div>

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('description', 'Description') }}
			            			{{ Form::textarea('description', $setting->description, array('class' => 'form-control input-lg textarea', 'placeholder' => 'Description', 'rows' => '18')) }}
			            		</div>
		              		</div>

		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
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
        	page_select('settings-manage', 'settings', 'Setting', 'update');
		});

    </script>

@endsection