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
		            {{ Form::open(array('url' => 'panel/permissions')) }}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-xs-12">
		              			<div class="form-group">
			            			{{ Form::label('display_name', 'Display Name') }}
			            			{{ Form::text('display_name', Input::old('display_name'), array('class' => 'form-control', 'id' => 'display_name', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('name', 'Name') }}
			            			{{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'id' => 'name', 'required' => 'required')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('description', 'Description') }}
			            			{{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
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
    	
    	$("#display_name").keyup(function(){
		    var display_name = $(this).val();
		    var name = display_name.replace(/\s+/g, '').toLowerCase();
		    $('#name').val(name);
		});

		$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('permissions-add', 'permissions', 'Permissions', 'Add');
		});

    </script>

@endsection