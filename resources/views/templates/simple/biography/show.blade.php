@extends('templates.simple.layouts.app')

@section('content')

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<div class="container inner">
      <h3 class="section-title text-center">{{ $biography->name }}</h3>
      <div class="divide20"></div>

  		<div class="row">
	        <div class="col-sm-5">
	          <figure><img src="{{ url('uploads/photos/thumb').'/'.$biography->image }}" alt="{{ $biography->name or '' }}"></figure>
	        </div>
	        <!-- /column -->
	        <div class="col-sm-7">

	          	<?php print $biography->description; ?>

				@if(count($socials) > 0)
					<ul class="social">
						@foreach($socials as $social)
							<li>
								<a href="{{ $social->url }}" target="_blank" title="{{ $social->name }}">
									@if($social->font_awesome != null)
										<i class="fa {{ $social->font_awesome }}"></i>
									@else
										<img src="{{ url('uploads/photos/full').'/'.$social->image }}" alt="{{ $social->name }}" style="width: 16px;">
									@endIf
								</a>
							</li>
						@endforeach						
					</ul>
					<!-- /.social-wrapper -->
				@endIf

				@if(isset($biography->youtube) && $biography->youtube != '')
					<iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $biography->youtube }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
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

			page_select('biographies', 'biographies');

		});

	</script>

@endsection