@extends('templates.simple.layouts.app')

@section('content')

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<div class="container inner">
      <h3 class="section-title text-center">{{ $award->name }}</h3>
      <div class="divide20"></div>

  		<div class="row">
	        <div class="col-sm-5">
	          <figure><img src="{{ url('uploads/photos/thumb').'/'.$award->image }}" alt="{{ $award->name or '' }}"></figure>
	        </div>
	        <!-- /column -->
	        <div class="col-sm-7">

	          	<?php print $award->description; ?>

				@if(isset($award->youtube) && $award->youtube != '')
					<iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $award->youtube }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				@endIf
				
		    </div>
		    <!-- /column --> 
	        
	   	</div>
	    <!-- /.row -->
      
      <div class="clearfix"></div>
    </div>
    <!--/.container --> 

	<!-- JS Social -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('awards', 'awards');

		});

	</script>

@endsection