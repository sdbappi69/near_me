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

    	<div class="row animated bounceInLeft">
	        <div class="col-md-4">
	    		<div class="box box-info">
		            <div class="box-header with-border">
		              <h3 class="box-title">Your Location</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->

		              	<div class="box-body">
		              		<div class="form-group">
		              			{{ Form::label('address', 'Address') }}
			              		{!! Form::text('address', Auth::user()->address, ['class' => 'form-control', 'placeholder' => 'Address', 'required' => 'required', 'id' => 'address']) !!}
			              	</div>
		              		<div class="form-group">
		              			<?php $geo_location = Auth::user()->latitude.",".Auth::user()->longitude; ?>
		              			{{ Form::label('geo_location', 'GEO Location') }}
			              		{!! Form::text('geo_location', $geo_location, ['class' => 'form-control', 'placeholder' => 'Latitude,Longitude', 'required' => 'required', 'id' => 'geo_location']) !!}
			              	</div>

		            		<!--The div element for the map -->
    						<div id="map"></div>
		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		                	<button class="btn btn-info" style="width: 100%">Update</button>
		              	</div>
		              	<!-- /.box-footer -->
		        </div>
	        </div>
	    </div>

    </section>

    <script type="text/javascript">
    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('dashboard', 'dashboard', '', '');
		});

		// Initialize and add the map
		function initMap() {
			var user_lat = "{{ Auth::user()->latitude }}";
			var user_lng = "{{ Auth::user()->longitude }}";
			var user_lat = parseFloat(user_lat);
			var user_lng = parseFloat(user_lng);

		  	// The location of Uluru
		  	var uluru = {lat: user_lat, lng: user_lng};
		  	// The map, centered at Uluru
		  	var map = new google.maps.Map(
		      	document.getElementById('map'), {zoom: 4, center: uluru});
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
                $('#geo_location').val(lat+','+lng);
            });


            // On Change GEO Location
            $("#geo_location").change(function() {
			    var geo_location = $('#geo_location').val();
			    var geo_array = geo_location.split(",");
			    var latitude = geo_array[0].split(' ').join('');
				var longitude = geo_array[1].split(' ').join('');
				alert(latitude);
			})

		}
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASbittvWIRzn6dxO24gC7gV3T6AwHWzac&libraries=places&callback=initMap&sensor=true">
    </script>

@endsection
