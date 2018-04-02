@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row animated bounceInDown">

	        <div class="col-xs-12">
	    		<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title">Edit</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            {!! Form::model($category, array('url' => 'panel/categories/'.$category->id, 'method' => 'put', 'enctype' => 'multipart/form-data')) !!}

		              	<div class="box-body">

		              		<!-- if there are creation errors, they will show here -->
							@include('partials.errors')

		              		<div class="col-md-6">
		              			<div class="form-group">
			            			{{ Form::label('name', 'Name*') }}
			            			{{ Form::text('name', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Name')) }}
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
			            			{{ Form::label('description', 'Description') }}
			            			{{ Form::text('description', null, array('class' => 'form-control input-lg', 'placeholder' => 'Description')) }}
			            		</div>
			            		<div class="form-group">
			            			{{ Form::label('thumbnail_size_id', 'Thumbnail image size') }}
			            			{!! Form::select('thumbnail_size_id', $sizes, null, ['class' => 'form-control js-example-basic-single input-lg', 'id' => 'thumbnail_size_id']) !!}
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
		              		<a href="{{ url('panel/categories') }}" class="btn btn-default">Cancel</a>
		                	<input type="submit" class="btn btn-info pull-right"  value="Update">
		              	</div>
		              	<!-- /.box-footer -->

		            {!! Form::close() !!}
		        </div>
	        </div>

	    </div>

	    <div class="row animated bounceInUp">
	        <div class="col-xs-12">
	          <div class="box box-info">
	            <div class="box-header">
		            <h3 class="box-title">Photos</h3>

		            <div class="box-tools">
		                <button  data-toggle="modal" data-target="#all-photos" class="btn btn-block btn-success">
		                	<i class="fa fa-pencil"></i> Update
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
		                </tr>

		                @if(count($category->photos) > 0)
		                	@foreach($category->photos AS $data)
		                		<tr>
		                			<td>
				                  		<div class="user-block">
						                    <img data-toggle="modal" data-target="#view-{{ $data->photo->id }}" class="img-circle img-bordered-sm img-view" src="{{ url('uploads/photos/thumb').'/'.$data->photo->image }}" alt="{{ $data->photo->name }}">
						                </div>
				                  	</td>
				                  	<td>{{ $data->photo->name }}</td>
				                  	<td>{{ $data->photo->product_id or '' }}</td>
				                  	<td>{{ $data->photo->price or '' }}</td>
				                  	<td>@if($data->photo->status == 1) Active @else Inactive @endIf</td>
				                  	<td>
				                  		@if($data->photo->status == 1)
					                  		<a href="{{ url('panel/categories/'.$data->photo->id.'/'.$category->id.'/photo-up') }}" class="btn btn-default"><i class="fa fa-arrow-up"></i></a>
					                  		<a href="{{ url('panel/categories/'.$data->photo->id.'/'.$category->id.'/photo-down') }}" class="btn btn-default"><i class="fa fa-arrow-down"></i></a>
				                  		@endIf
				                  	</td>
				                </tr>

		                	@endforeach
		                @endIf

	              	</table>

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	    </div>

    </section>

    @if(count($category->photos) > 0)
		@foreach($category->photos AS $data)

			<div class="modal fade" id="view-{{ $data->photo->id }}">
	          	<div class="modal-dialog" style="width: {{ $data->photo->size->width + 30 }}px;">
		            <div class="modal-content">
		              <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                  <span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">{{ $data->photo->name }}</h4>
		              </div>
		              <div class="modal-body">
		              		<img src="{{ url('uploads/photos/full').'/'.$data->photo->image }}" alt="{{ $data->photo->name }}">
		              </div>
		            </div>
		            <!-- /.modal-content -->
	          	</div>
	          	<!-- /.modal-dialog -->
	        </div>
	        <!-- /.modal -->

		@endforeach
	@endIf

	<div class="modal fade" id="all-photos">
      	<div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">All photos</h4>
              </div>

              {{ Form::open(array('url' => 'panel/categories/photos')) }}

              		{{ Form::hidden('category_id', $category->id) }}

	              	<div class="modal-body table-responsive">
	              		
	              		<table class="table table-striped">

			                <tr>
			                  	<th>#</th>
			                  	<th>Image</th>
			                  	<th>Name</th>
			                  	<th>Product id</th>
			                </tr>

			                @if(count($photos) > 0)
			                	@foreach($photos AS $photo)
			                		<tr>
			                			<td><input type="checkbox" name="photo_ids[]" value="{{ $photo->id }}" @if(in_array($photo->id, $current_photos)) checked @endIf></td>
			                			<td>
					                  		<div class="user-block">
							                    <img class="img-circle img-bordered-sm img-view" src="{{ url('uploads/photos/thumb').'/'.$photo->image }}" alt="{{ $photo->name }}">
							                </div>
					                  	</td>
					                  	<td>{{ $photo->name }}</td>
					                  	<td>{{ $photo->product_id or '' }}</td>
					                </tr>
			                	@endforeach
			                @endIf

		              	</table>

	              	</div>

	              	<div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		                <button type="submit" class="btn btn-primary">Save changes</button>
	              	</div>

              {!! Form::close() !!}

            </div>
            <!-- /.modal-content -->
      	</div>
      	<!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script type="text/javascript">
    	
    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('categories-manage', 'categories', 'Categories', 'update');
		});

    </script>

@endsection