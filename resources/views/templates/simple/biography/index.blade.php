@extends('templates.simple.layouts.app')

@section('content')

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<div class="container inner">
      <h3 class="section-title text-center">About Me</h3>
      <div class="divide20"></div>

      @if(count($biographies) > 0)

      	@foreach($biographies AS $biography)

      		<div class="row">
		        <div class="col-sm-5">
		          <figure><img src="{{ url('uploads/photos/thumb').'/'.$biography->image }}" alt="{{ $biography->name or '' }}"></figure>
		        </div>
		        <!-- /column -->
		        <div class="col-sm-7">

		          	<?php
						$description = $biography->description;
						$print = substr($description, 0, 1000);
						if(strlen($description) > 1000){
							$print = $print.'...';
						}
						$print = $print.' <a href="'.url("biographies").'/'.$biography->id.'">See more</a>';
						print $print;
					?>

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

			page_select('biographies', 'biographies');

		});

	</script>

@endsection