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
		            			<?php if (!isset($_GET['date'])) { $_GET['date'] = null; } ?>
		            			<div class="input-group">
				                  	<div class="input-group-addon">
				                    	<i class="fa fa-calendar"></i>
				                  	</div>
				                  	<input type="text" name="date" value="{{ $_GET['date'] }}" class="form-control input-lg" placeholder="Date" id="datepicker" data-date-format='yyyy-mm-dd'>
				                </div>
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['description'])) { $_GET['description'] = null; } ?>
		            			<input value="{{ $_GET['description'] }}" class="form-control input-lg" name="description" type="text" placeholder="Description">
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
		            <h3 class="box-title">Award</h3>

		            <div class="box-tools">
		                <a href="{{ url('panel/awards/create') }}" class="btn btn-block btn-success">
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
		                  	<th>date</th>
		                  	<th>URL</th>
		                  	<th>Status</th>
		                  	@permission('award-update')
		                  		<th>Priority</th>
		                  	@endpermission
		                  	<th>Actions</th>
		                </tr>

		                @if(count($awards) > 0)
		                	@foreach($awards AS $award)
		                		<tr>
		                			<td>
				                  		<div class="user-block">
				                  			@if(isset($award->image) && $award->image != null)
						                    	<img class="img-circle img-bordered-sm" src="{{ url('uploads/photos/thumb').'/'.$award->image }}" alt="{{ $award->name }}">
						                    @endIf
						                </div>
				                  	</td>
				                  	<td>{{ $award->name }}</td>
				                  	<td>{{ $award->date }}</td>
				                  	<td>{{ $award->url }}</td>
				                  	<td>@if($award->status == 1) Active @else Inactive @endIf</td>
				                  	@permission('award-update')
					                  	<td>
					                  		@if($award->status == 1)
						                  		<a href="{{ url('panel/awards/'.$award->id.'/up') }}" class="btn btn-default"><i class="fa fa-arrow-up"></i></a>
						                  		<a href="{{ url('panel/awards/'.$award->id.'/down') }}" class="btn btn-default"><i class="fa fa-arrow-down"></i></a>
					                  		@endIf
					                  	</td>
				                  	@endpermission
				                  	<td>
				                  		<div class="btn-group">
					                      	{{ Form::open(array('url' => 'panel/awards/'.$award->id)) }}
							                    {{ Form::hidden('_method', 'DELETE') }}
							                    <!-- <a href="{{ url('panel/awards/'.$award->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a> -->
					                      		@permission('award-update')
					                      			<a href="{{ url('panel/awards/'.$award->id.'/edit') }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
					                      		@endpermission
							                    @permission('award-delete')
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
                        {{ $awards->appends($_REQUEST)->render() }}
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
        	page_select('awards-manage', 'awards', 'Awards', 'Manage');
		});
    </script>

@endsection