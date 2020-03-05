@extends('layouts.app')

@section('content')

	<style>
		#map {
		   width: 100%;
		   height: 400px;
		   background-color: grey;
		}
		.gm-style-iw-d{
			color: #666666;
		}
	</style>

	<!-- Main content -->
    <section class="content">

    	<div class="row">
	        <div class="col-md-4 animated bounceInLeft">
	    		<div class="box box-info">
		            <div class="box-header with-border">
		              <h3 class="box-title">Your Location</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->

		              	<div class="box-body">
		              		<div class="form-group">
		              			{{ Form::label('address', 'Address') }}
			              		{!! Form::text('address', Auth::user()->address, ['class' => 'form-control input-lg', 'placeholder' => 'Address', 'required' => 'required', 'id' => 'address']) !!}
			              	</div>
		              		<div class="form-group">
		              			<?php 
		              				if(Auth::user()->latitude != null && Auth::user()->longitude != null){
		              					$geo_location = Auth::user()->latitude.",".Auth::user()->longitude; 
		              				}else{
		              					$geo_location = "";
		              				}
		              			?>
		              			{{ Form::label('geo_location', 'GEO Location') }}
			              		{!! Form::text('geo_location', $geo_location, ['class' => 'form-control input-lg', 'placeholder' => 'Latitude,Longitude', 'required' => 'required', 'id' => 'geo_location']) !!}
			              	</div>

		            		<!--The div element for the map -->
    						<div id="map"></div>
		              	</div>
		              	<!-- /.box-body -->
		              	<!-- <div class="box-footer">
		                	<button class="btn btn-info" style="width: 100%">Update</button>
		              	</div> -->
		              	<!-- /.box-footer -->
		        </div>
	        </div>

	        <div class="col-md-8 animated bounceInRight">
	    		<div class="box box-info">
		            <div class="box-header with-border">
		              <h3 class="box-title">Search</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            {!! Form::open(array('method' => 'get')) !!}

		            	<input value="{{ Auth::user()->latitude }}" name="latitude" type="hidden" required="required" id="latitude">
		            	<input value="{{ Auth::user()->longitude }}" name="longitude" type="hidden" required="required" id="longitude">

		              	<div class="box-body">
		            		<div class="col-md-4">
		            			{{ Form::label('radius', 'Enter Radius*') }}
		            			<?php if (!isset($_GET['radius'])) { $_GET['radius'] = null; } ?>
		            			<input value="{{ $_GET['radius'] }}" class="form-control input-lg" name="radius" type="number" placeholder="Enter Radius" required="required">
		            		</div>

					        <div class="col-md-4">
					        	{{ Form::label('type_id', 'Select Type*') }}
					        	<?php if(!isset($_GET['type_id'])){$_GET['type_id'] = null;} ?>
					            {!! Form::select('type_id', ['' => 'Select Type']+$types, $_GET['type_id'], ['class' => 'form-control input-lg select2','id' => 'type_id','required' => 'required']) !!}
					        </div>

		            		<div class="col-md-4">
		            			{{ Form::label('keyword', 'Enter Keyword') }}
		            			<?php if (!isset($_GET['keyword'])) { $_GET['keyword'] = null; } ?>
		            			<input value="{{ str_replace('+', ' ', $_GET['keyword']) }}" class="form-control input-lg" name="keyword" type="text" placeholder="Enter Keyword">
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

	        @if(isset($response))

		        <div class="col-md-8 animated bounceInUp">
		    		<div class="box box-info">
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
				                	<?php $response = json_decode($response); ?>
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

	        @endif

	    </div>

    </section>

    <script type="text/javascript">
    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('dashboard', 'dashboard', '', '');
		});

		// Initialize and add the map
		function initMap(user_lat = "{{ Auth::user()->latitude }}", user_lng = "{{ Auth::user()->longitude }}") {
			// var user_lat = "{{ Auth::user()->latitude }}";
			// var user_lng = "{{ Auth::user()->longitude }}";
			var user_lat = parseFloat(user_lat);
			var user_lng = parseFloat(user_lng);

		  	// The location of Uluru
		  	var uluru = {lat: user_lat, lng: user_lng};
		  	// The map, centered at Uluru
		  	var map = new google.maps.Map(
		      	document.getElementById('map'), {zoom: 15, center: uluru});
		  	// The marker, positioned at Uluru
		  	var marker = new google.maps.Marker({position: uluru, map: map});

		  	// Auto Complete
		  	var infowindow = new google.maps.InfoWindow();
		  	var autocomplete = new google.maps.places.Autocomplete($("#address")[0], {});
		  	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		  		infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                // console.log(place.geometry.location);
                if (!place.geometry) {
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);

                $('#address').val(place.name + ', ' + address);
            });


		  	// On change pointer
            google.maps.event.addListener(marker, 'position_changed', function () {
            	// console.log(marker.getPosition());
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                var geo_location = lat+','+lng;
                $('#geo_location').val(geo_location);
                updateLocation(geo_location);
            });


            // Click Event
            google.maps.event.addListener(map, "click", function (e) {
			    //lat and lng is available in e object
			    var lat = e.latLng.lat();
			    var lng = e.latLng.lng();

	   			var latlng = new google.maps.LatLng(lat, lng);
	            var geocoder = geocoder = new google.maps.Geocoder();
	            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
	                if (status == google.maps.GeocoderStatus.OK) {
	                    if (results[1]) {
	                        // alert("Location: " + results[1].formatted_address);
	                        $('#address').val(results[1].formatted_address);
	                    }
	                }
	            });

	            var geo_location = lat+','+lng;
	   			$('#geo_location').val(geo_location);
	   			updateLocation(geo_location);
	   			initMap(lat, lng);

			});

		}

		// On Change GEO Location Directly
        $("#geo_location").change(function() {
		    var geo_location = $('#geo_location').val();
		    var geo_array = geo_location.split(",");
		    var latitude = geo_array[0].split(' ').join('');
			var longitude = geo_array[1].split(' ').join('');

			latitude = parseFloat(latitude);
			longitude = parseFloat(longitude);

			var latlng = new google.maps.LatLng(latitude, longitude);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        // alert("Location: " + results[1].formatted_address);
                        $('#address').val(results[1].formatted_address);
                    }
                }
            });

            updateLocation(geo_location);
			initMap(latitude, longitude);
		});

		function updateLocation(new_location){
		    var new_array = new_location.split(",");
		    var new_lat = new_array[0].split(' ').join('');
			var new_lon = new_array[1].split(' ').join('');
			new_lat = parseFloat(new_lat);
			new_lon = parseFloat(new_lon);

			$('#latitude').val(new_lat);
			$('#longitude').val(new_lon);

			user_lat = "{{ Auth::user()->latitude }}";
			user_lng = "{{ Auth::user()->longitude }}";
			user_lat = parseFloat(user_lat);
			user_lng = parseFloat(user_lng);

			if(new_lat != user_lat || new_lon != user_lng){

				$.ajaxSetup({
			      headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        }
			    });
				
				var formData = {
	                'address': $('#address').val(),
	                'latitude': new_lat,
	                'longitude': new_lon
	            };
	            // console.log(formData);

	            var update_location_url = "{{ url('/') }}/panel/update-location";

	            $.post(update_location_url, formData,
				function(data, status){
				    console.log(data);
				});

			}
		}

    </script>

    <?php $maps_url = "https://maps.googleapis.com/maps/api/js?key=".config('app.google_api_key')."&libraries=places&callback=initMap"; ?>

    <script async defer src="{{ $maps_url }}"></script>

@endsection
