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
		            			<?php if (!isset($_GET['product_id'])) { $_GET['product_id'] = null; } ?>
		            			<input value="{{ $_GET['product_id'] }}" class="form-control input-lg" name="product_id" type="text" placeholder="Product id">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['price'])) { $_GET['price'] = null; } ?>
		            			<input value="{{ $_GET['price'] }}" class="form-control input-lg" name="price" type="text" placeholder="Price">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['description'])) { $_GET['description'] = null; } ?>
		            			<input value="{{ $_GET['description'] }}" class="form-control input-lg" name="description" type="text" placeholder="Description">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['category_id'])) { $_GET['category_id'] = null; } ?>
		            			{!! Form::select('category_id', ['' => 'All categories']+$categories, $_GET['category_id'], ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'category_id']) !!}
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['thumbnail_size_id'])) { $_GET['thumbnail_size_id'] = null; } ?>
		            			{!! Form::select('thumbnail_size_id', ['' => 'All thumbnail image size']+$sizes, $_GET['thumbnail_size_id'], ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'thumbnail_size_id']) !!}
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['size_id'])) { $_GET['size_id'] = null; } ?>
		            			{!! Form::select('size_id', ['' => 'All full image size']+$sizes, $_GET['size_id'], ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'size_id']) !!}
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
		            <h3 class="box-title">Photo</h3>

		            <div class="box-tools">
		                <a href="{{ url('panel/sales/create') }}" class="btn btn-block btn-success">
		                	<i class="fa fa-plus"></i> Create new
		                </a>
	              	</div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body table-responsive">
	              	<table class="table table-striped">

		                <tr>
		                  	<th>Image</th>
		                  	<th>Name</th>
		                  	<th>Product id</th>
		                  	<th>Price</th>
		                  	<th>Status</th>
		                  	<th>Priority</th>
		                  	<th>Actions</th>
		                </tr>

		                @if(count($sales) > 0)
		                	@foreach($sales AS $photo)
		                		<tr>
		                			<td>
				                  		<div class="user-block">
						                    <img data-toggle="modal" data-target="#view-{{ $photo->id }}" class="img-circle img-bordered-sm img-view" src="{{ url('uploads/photos/thumb').'/'.$photo->image }}" alt="{{ $photo->name }}">
						                </div>
				                  	</td>
				                  	<td>{{ $photo->name }}</td>
				                  	<td>{{ $photo->product_id }}</td>
				                  	<td>{{ $photo->price }}</td>
				                  	<td>@if($photo->status == 1) Active @else Inactive @endIf</td>
				                  	<td>
				                  		@if($photo->status == 1)
					                  		<a href="{{ url('panel/sales/'.$photo->id.'/up') }}" class="btn btn-default"><i class="fa fa-arrow-up"></i></a>
					                  		<a href="{{ url('panel/sales/'.$photo->id.'/down') }}" class="btn btn-default"><i class="fa fa-arrow-down"></i></a>
				                  		@endIf
				                  	</td>
				                  	<td>
				                  		<div class="btn-group">
					                      	{{ Form::open(array('url' => 'panel/sales/'.$photo->id)) }}
							                    {{ Form::hidden('_method', 'DELETE') }}
							                    <!-- <a href="{{ url('panel/sales/'.$photo->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a> -->
					                      		<a href="{{ url('panel/sales/'.$photo->id.'/edit') }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							                    <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
							                {{ Form::close() }}
					                    </div>
				                  	</td>
				                </tr>

		                	@endforeach
		                @endIf

	              	</table>

	              	<div class="pagination pull-right">
                        {{ $sales->appends($_REQUEST)->render() }}
                    </div>

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	    </div>

    </section>

    @if(count($sales) > 0)
		@foreach($sales AS $photo)

			<div class="modal fade" id="view-{{ $photo->id }}">
	          	<div class="modal-dialog" style="width: {{ $photo->size->width + 30 }}px; max-width: 80%;">
		            <div class="modal-content">
		              <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                  <span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">{{ $photo->name }}</h4>
		              </div>
		              <div class="modal-body">
		              		<img src="{{ url('uploads/photos/full').'/'.$photo->image }}" alt="{{ $photo->name }}" style="width: 100%">
		              </div>
		            </div>
		            <!-- /.modal-content -->
	          	</div>
	          	<!-- /.modal-dialog -->
	        </div>
	        <!-- /.modal -->

		@endforeach
	@endIf

    <script type="text/javascript">
    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('sales-manage', 'sales', 'Sell', 'Manage');
		});
    </script>

@endsection