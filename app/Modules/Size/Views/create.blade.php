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
		            {{ Form::open(array('url' => 'panel/sizes')) }}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-xs-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', Input::old('name'), array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'ex: Profile picture')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('status', 'Status*') }}
			            			{!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], Input::old('status'), ['class' => 'form-control input-lg', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('default', 'Default*') }}
			            			{!! Form::select('default', ['0' => 'No', '1' => 'Yes'], Input::old('default'), ['class' => 'form-control input-lg', 'required' => 'required']) !!}
			            		</div>
		              		</div>

		              		<div class="col-xs-6">
			            		<div class="form-group">
			            			{{ Form::label('width', 'Width*') }}
			            			{{ Form::number('width', Input::old('width'), array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'px')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('height', 'Height*') }}
			            			{{ Form::number('height', Input::old('height'), array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'px')) }}
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
        	page_select('sizes-add', 'sizes', 'Sizes', 'Add');
		});

    </script>

@endsection