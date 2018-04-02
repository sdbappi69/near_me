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
		            {!! Form::model($size, array('url' => 'panel/sizes/'.$size->id, 'method' => 'put')) !!}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'ex: Profile picture')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('status', 'Status*') }}
			            			{!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], null, ['class' => 'form-control input-lg', 'required' => 'required']) !!}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('default', 'Default*') }}
			            			{!! Form::select('default', ['0' => 'No', '1' => 'Yes'], null, ['class' => 'form-control input-lg', 'required' => 'required']) !!}
			            		</div>
		              		</div>

		              		<div class="col-md-6">
			            		<div class="form-group">
			            			{{ Form::label('width', 'Width*') }}
			            			{{ Form::number('width', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'px')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('height', 'Height*') }}
			            			{{ Form::number('height', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'px')) }}
			            		</div>
		              		</div>

		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		              		<a href="{{ url('panel/sizes') }}" class="btn btn-default">Cancel</a>
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
        	page_select('sizes-manage', 'sizes', 'Sizes', 'update');
		});

    </script>

@endsection