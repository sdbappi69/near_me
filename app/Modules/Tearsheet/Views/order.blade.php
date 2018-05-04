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
		            			<input value="{{ $_GET['name'] }}" class="form-control input-lg" name="name" type="text" placeholder="Client's Name">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['order_id'])) { $_GET['order_id'] = null; } ?>
		            			<input value="{{ $_GET['order_id'] }}" class="form-control input-lg" name="order_id" type="text" placeholder="Order id">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['email'])) { $_GET['email'] = null; } ?>
		            			<input value="{{ $_GET['email'] }}" class="form-control input-lg" name="email" type="text" placeholder="Email">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['contact'])) { $_GET['contact'] = null; } ?>
		            			<input value="{{ $_GET['contact'] }}" class="form-control input-lg" name="contact" type="text" placeholder="Contact">
		            		</div>
		            		<div class="col-md-3">
		            			<?php if (!isset($_GET['description'])) { $_GET['description'] = null; } ?>
		            			<input value="{{ $_GET['description'] }}" class="form-control input-lg" name="description" type="text" placeholder="Description">
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

		            <div class="box-tools"></div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body table-responsive">
	              	<table class="table table-striped">

		                <tr>
		                	<th>Image</th>
		                	<th>Order id</th>
		                	<th>Photo id</th>
		                	<th>Photo name</th>
		                	<th>Price</th>
		                	<th>Date</th>
		                  	<th>Client's name</th>
		                  	<th>Client's email</th>
		                  	<th>Client's contact</th>
		                  	<th>Client's notes</th>
		                </tr>

		                @if(count($orders) > 0)
		                	@foreach($orders AS $order)
		                		<tr>
		                			<td>
				                  		<div class="user-block">
						                    <img data-toggle="modal" data-target="#view-{{ $order->photo->id }}" class="img-circle img-bordered-sm img-view" src="{{ url('uploads/photos/thumb').'/'.$order->photo->image }}" alt="{{ $order->photo->name }}">
						                </div>
				                  	</td>
				                  	<td>{{ $order->order_id or '' }}</td>
				                  	<td>{{ $order->photo->product_id or '' }}</td>
				                  	<td>{{ $order->photo->name or '' }}</td>
				                  	<td>{{ $order->photo->price or '' }}</td>
				                  	<td>{{ $order->created_at }}</td>
				                  	<td>{{ $order->name or '' }}</td>
				                  	<td>{{ $order->email or '' }}</td>
				                  	<td>{{ $order->contact or '' }}</td>
				                  	<td>{{ $order->description or '' }}</td>
				                </tr>

		                	@endforeach
		                @endIf

	              	</table>

	              	<div class="pagination pull-right">
                        {{ $orders->appends($_REQUEST)->render() }}
                    </div>

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	    </div>

    </section>

    @if(count($orders) > 0)
		@foreach($orders AS $order)

			<div class="modal fade" id="view-{{ $order->photo->id }}">
	          	<div class="modal-dialog" style="width: {{ $order->photo->size->width + 30 }}px; max-width: 80%;">
		            <div class="modal-content">
		              <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                  <span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">{{ $order->photo->name }}</h4>
		              </div>
		              <div class="modal-body">
		              		<img src="{{ url('uploads/photos/full').'/'.$order->photo->image }}" alt="{{ $order->photo->name }}" style="width: 100%">
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
        	page_select('tearsheets-order', 'tearsheets', 'Tearsheet', 'Order');
		});
    </script>

@endsection