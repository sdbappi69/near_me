@extends('templates.airy.layouts.app')

@section('content')

	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/columns.min.css') }}" media="screen" />

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<div class="wrapper">

		@if(count($videos) > 0)

			@foreach($videos AS $video)

				<div class="column-grid column-grid-3">
					<div class="column column-span-1 column-push-0 column-first">
						<img src="{{ url('uploads/photos/thumb').'/'.$video->image }}" alt="{{ $video->name or '' }}"/>
					</div>
					<div class="column column-span-2 column-push-0 column-last">
						<p class=""><strong>{{ $video->name or '' }}</strong></p>

						<?php
							$description = $video->description;
							$print = substr($description, 0, 1000);
							if(strlen($description) > 1000){
								$print = $print.'...';
							}
							$print = $print.' <a href="'.url("videos").'/'.$video->id.'">See more</a>';
							print $print;
						?>
					</div>
				</div>

			@endforeach

		@endIf

		<div id="shareIcons" style="float: left;"></div>

		<div class="pagination" style="float: right;">
            {{ $videos->appends($_REQUEST)->render() }}
        </div>

		<hr class="divider" />

	</div><!-- END .wrapper -->

	<!-- include Masonry -->
	<script src="{{ URL::asset('templates/airy/js/isotope.pkgd.min.js') }}"></script>

	<!-- JS Social -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('videos', 'videos');

		});

	</script>

@endsection