@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row animated bounceInDown">
	        <div class="col-xs-12">
	    		<div class="box box-info">
		            <div class="box-header with-border">
		              <h3 class="box-title">Filter</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            {!! Form::open(array('method' => 'get')) !!}

		              	<div class="box-body">
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['name'])) { $_GET['name'] = null; } ?>
		            			<input value="{{ $_GET['name'] }}" class="form-control input-lg" name="name" type="text" placeholder="Name">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['width'])) { $_GET['width'] = null; } ?>
		            			<input value="{{ $_GET['width'] }}" class="form-control input-lg" name="width" type="text" placeholder="Width">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['height'])) { $_GET['height'] = null; } ?>
		            			<input value="{{ $_GET['height'] }}" class="form-control input-lg" name="height" type="text" placeholder="Height">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['status'])) { $_GET['status'] = null; } ?>
		            			{!! Form::select('status', ['' => 'Status', '1' => 'Active', '0' => 'Inactive'], $_GET['status'], ['class' => 'form-control input-lg', 'id' => 'status']) !!}
		            		</div>
		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		                	<input type="reset" class="btn btn-default" value="Reset">
		                	<input type="submit" class="btn btn-info pull-right"  value="Search">
		              	</div>
		              	<!-- /.box-footer -->

		            {!! Form::close() !!}
		        </div>
	        </div>
	    </div>

    	<div class="row animated bounceInUp">
	        <div class="col-xs-12">
	          <div class="box box-success">
	            <div class="box-header">
		            <h3 class="box-title">Size</h3>

		            <div class="box-tools">
		                <a href="{{ url('panel/sizes/create') }}" class="btn btn-block btn-success">
		                	<i class="fa fa-plus"></i> Create new
		                </a>
	              	</div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body table-responsive">
	              	<table class="table table-striped">

		                <tr>
		                  	<th>Name</th>
		                  	<th>Width(px)</th>
		                  	<th>Height(px)</th>
		                  	<th>Default</th>
		                  	<th>Status</th>
		                  	<th>Actions</th>
		                </tr>

		                @if(count($sizes) > 0)
		                	@foreach($sizes AS $size)
		                		<tr>
				                  	<td>{{ $size->name }}</td>
				                  	<td>{{ $size->width }}</td>
				                  	<td>{{ $size->height }}</td>
				                  	<td>@if($size->default == 1) <i class="fa fa-check"></i> @endIf</td>
				                  	<td>@if($size->status == 1) Active @else Inactive @endIf</td>
				                  	<td>
				                  		<div class="btn-group">
					                      	{{ Form::open(array('url' => 'panel/sizes/'.$size->id)) }}
							                    {{ Form::hidden('_method', 'DELETE') }}
							                    <!-- <a href="{{ url('panel/sizes/'.$size->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a> -->
					                      		@permission('size-update')
					                      			<a href="{{ url('panel/sizes/'.$size->id.'/edit') }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
					                      		@endpermission
							                    @permission('size-delete')
							                    	<button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
							                    @endpermission
							                {{ Form::close() }}
					                    </div>
				                  	</td>
				                </tr>
		                	@endforeach
		                @endIf

	              	</table>

	              	<div class="pagination pull-right">
                        {{ $sizes->appends($_REQUEST)->render() }}
                    </div>

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	    </div>

    </section>

    <script type="text/javascript">
    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('sizes-manage', 'sizes', 'Sizes', 'Manage');
		});
    </script>

@endsection