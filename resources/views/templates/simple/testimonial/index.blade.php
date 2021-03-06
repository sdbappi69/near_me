@extends('templates.simple.layouts.app')

@section('content')

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<div class="container inner">
      <h3 class="section-title text-center">Testimonials</h3>
      <div class="divide20"></div>

      @if(count($testimonials) > 0)

      	@foreach($testimonials AS $testimonial)

      		<div class="row">
		        <div class="col-sm-5">
		          <figure><img src="{{ url('uploads/photos/thumb').'/'.$testimonial->image }}" alt="{{ $testimonial->name or '' }}"></figure>
		        </div>
		        <!-- /column -->
		        <div class="col-sm-7">

		          	<?php
						$description = $testimonial->description;
						$print = substr($description, 0, 1000);
						if(strlen($description) > 1000){
							$print = $print.'...';
						}
						$print = $print.' <a href="'.url("testimonials").'/'.$testimonial->id.'">See more</a>';
						print $print;
					?>
					
			    </div>
			    <!-- /column --> 
		        
		   	</div>
		    <!-- /.row -->

      	@endforeach

      @endIf
      
      <div class="clearfix"></div>
    </div>
    <!--/.container --> 

	<!-- JS Social -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('testimonialz', 'testimonialz');

		});

	</script>

@endsection