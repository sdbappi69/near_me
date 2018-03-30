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
		            		<div class="col-xs-3">
		            			<?php if (!isset($_GET['name'])) { $_GET['name'] = null; } ?>
		            			<input value="{{ $_GET['name'] }}" class="form-control input-lg" name="name" type="text" placeholder="Name">
		            		</div>
		            		<div class="col-xs-3">
		            			<?php if (!isset($_GET['description'])) { $_GET['description'] = null; } ?>
		            			<input value="{{ $_GET['description'] }}" class="form-control input-lg" name="description" type="text" placeholder="Description">
		            		</div>
		            		<div class="col-xs-3">
		            			<?php if (!isset($_GET['thumbnail_size_id'])) { $_GET['thumbnail_size_id'] = null; } ?>
		            			{!! Form::select('thumbnail_size_id', ['' => 'Thumbnail image size']+$sizes, $_GET['thumbnail_size_id'], ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'thumbnail_size_id']) !!}
		            		</div>
		            		<div class="col-xs-3">
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
		            <h3 class="box-title">Category</h3>

		            <div class="box-tools">
		                <a href="{{ url('categories/create') }}" class="btn btn-block btn-success">
		                	<i class="fa fa-plus"></i> Create new
		                </a>
	              	</div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body table-responsiveusers">
	              	<table class="table table-striped">

		                <tr>
		                  	<th>Image</th>
		                  	<th>Name</th>
		                  	<th>Description</th>
		                  	<th>Default</th>
		                  	<th>Status</th>
		                  	<th>Priority</th>
		                  	<th>Actions</th>
		                </tr>

		                @if(count($categories) > 0)
		                	@foreach($categories AS $category)
		                		<tr>
		                			<td>
				                  		<div class="user-block">
						                    <img class="img-circle img-bordered-sm" src="{{ url('uploads/photos/thumb').'/'.$category->image }}" alt="{{ $category->name }}">
						                </div>
				                  	</td>
				                  	<td>{{ $category->name }}</td>
				                  	<td>{{ $category->description }}</td>
				                  	<td>@if($category->default == 1) <i class="fa fa-check"></i> @endIf</td>
				                  	<td>@if($category->status == 1) Active @else Inactive @endIf</td>
				                  	<td>
				                  		@if($category->status == 1)
					                  		<a href="{{ url('categories/'.$category->id.'/up') }}" class="btn btn-default"><i class="fa fa-arrow-up"></i></a>
					                  		<a href="{{ url('categories/'.$category->id.'/down') }}" class="btn btn-default"><i class="fa fa-arrow-down"></i></a>
				                  		@endIf
				                  	</td>
				                  	<td>
				                  		<div class="btn-group">
					                      	{{ Form::open(array('url' => 'categories/'.$category->id)) }}
							                    {{ Form::hidden('_method', 'DELETE') }}
							                    <!-- <a href="{{ url('categories/'.$category->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a> -->
					                      		<a href="{{ url('categories/'.$category->id.'/edit') }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							                    <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
							                {{ Form::close() }}
					                    </div>
				                  	</td>
				                </tr>
		                	@endforeach
		                @endIf

	              	</table>

	              	<div class="pagination pull-right">
                        {{ $categories->appends($_REQUEST)->render() }}
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
        	page_select('categories-manage', 'categories', 'Categories', 'Manage');
		});
    </script>

@endsection