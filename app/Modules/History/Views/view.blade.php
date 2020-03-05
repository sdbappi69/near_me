@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row">

    		<div class="col-md-12 animated bounceInDown">
				<div class="box box-success">
		            <div class="box-header with-border">
		              <h3 class="box-title">Places</h3>
		            </div>
		            <!-- /.box-header -->

		          	<div class="box-body table-responsive">
		        		
		          		<table id="example1" class="table table-bordered table-striped example1">
			                <thead>
				                <tr>
				                  	<th>Icon</th>
				                  	<th>Name</th>
				                  	<th>Address</th>
				                  	<th>Open</th>
				                  	<th>Location</th>
				                </tr>
			                </thead>
			                <tbody>
			                	<?php $response = json_decode($history->response); ?>
			                	@foreach($response->results AS $result)
				                <tr>
				                  	<td style="text-align: center;">
				                  		<img style="width: 30px; background-color: #FFFFFF; padding: 5px;" src="{{ $result->icon }}" alt="{{ $result->name }}">
				                  	</td>
				                  	<td>{{ $result->name or '' }}</td>
				                  	<td>{{ $result->vicinity or '' }}</td>
				                  	<td>
				                  		@if(isset($result->opening_hours))
					                  		@foreach($result->opening_hours as $opening_hour)
					                  			@if(isset($opening_hour) && $opening_hour == true)
					                  				Yes
					                  			@else
					                  				No
					                  			@endif
					                  		@endforeach
				                  		@endif
				                  	</td>
				                  	<td>
				                  		@if(isset($result->geometry))
					                  		@foreach($result->geometry as $geometry)
					                  			@if(isset($geometry->lat) && isset($geometry->lng))
					                  				<a href="https://www.google.com/maps/search/?api=1&query={{ $geometry->lat }},{{ $geometry->lng }}" target="_blank" class="btn btn-success">
					                  					Location
					                  				</a>
					                  				<span style="display: none;">{{ $geometry->lat }},{{ $geometry->lng }}</span>
					                  			@endif
					                  		@endforeach
				                  		@endif
				                  	</td>
				                </tr>
				                @endforeach
				            </tbody>
			            </table>

		          	</div>
		          	<!-- /.box-body -->
		        </div>
		    </div>
    		
    	</div>

    </section>

    <script type="text/javascript">

	    $(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('history', 'history', 'History', 'Detail');
		});

    </script>

@endsection