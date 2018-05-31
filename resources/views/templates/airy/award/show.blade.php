@extends('templates.airy.layouts.app')

@section('content')

	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/columns.min.css') }}" media="screen" />

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<div class="wrapper">

		<div class="column-grid column-grid-3">

			<div class="column column-span-1 column-push-0 column-first">
				<figure class="image-with-caption">
					<a href="{{ url('uploads/photos/full').'/'.$award->image }}" class="popup"><img src="{{ url('uploads/photos/thumb').'/'.$award->image }}" alt="{{ $award->name or '' }}" /></a>
					<figcaption>
						<div class="entry-summary">
							<h3>{{ $award->name or '' }}</h3>
						</div>
					</figcaption>
				</figure>
				@if(isset($award->url) && $award->url != '')
					<a class="button" href="{{ $award->url or '' }}">#Link</a>
				@endIf
				@if(isset($award->video_url) && $award->video_url != '')
					<a class="button" href="{{ $award->video_url or '' }}">#Video</a>
				@endIf
				@if(isset($award->social_url) && $award->social_url != '')
					<a class="button" href="{{ $award->social_url or '' }}">#Social</a>
				@endIf
			</div>

			<div class="column column-span-2 column-push-0 column-last">
				<h4><strong>{{ $award->name or '' }}</strong></h4>

				@if(isset($award->date) && $award->date != '')
					<p class="small"><em>{{ $award->date or '' }}</em></p>
				@endIf

				<?php print $award->description; ?>

				@if(isset($award->youtube) && $award->youtube != '')
					<iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $award->youtube }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				@endIf

			</div>

		</div>

		<div id="shareIcons" style="float: left;"></div>

		<hr class="divider" />

	</div><!-- END .wrapper -->

	<!-- include Masonry -->
	<script src="{{ URL::asset('templates/airy/js/isotope.pkgd.min.js') }}"></script>

	<!-- JS Social -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('awards', 'awards');

		});

	</script>

@endsection