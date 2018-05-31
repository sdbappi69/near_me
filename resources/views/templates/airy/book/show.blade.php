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
					<a href="{{ url('uploads/photos/full').'/'.$book->image }}" class="popup"><img src="{{ url('uploads/photos/thumb').'/'.$book->image }}" alt="{{ $book->name or '' }}" /></a>
					<figcaption>
						<div class="entry-summary">
							<h3>{{ $book->name or '' }}</h3>
						</div>
					</figcaption>
				</figure>
				@if(isset($book->url) && $book->url != '')
					<a class="button" href="{{ $book->url or '' }}">#Link</a>
				@endIf
				@if(isset($book->video_url) && $book->video_url != '')
					<a class="button" href="{{ $book->video_url or '' }}">#Video</a>
				@endIf
				@if(isset($book->social_url) && $book->social_url != '')
					<a class="button" href="{{ $book->social_url or '' }}">#Social</a>
				@endIf
			</div>

			<div class="column column-span-2 column-push-0 column-last">
				<h4><strong>{{ $book->name or '' }}</strong></h4>

				@if(isset($book->date) && $book->date != '')
					<p class="small"><em>{{ $book->date or '' }}</em></p>
				@endIf

				<?php print $book->description; ?>

				@if(isset($book->youtube) && $book->youtube != '')
					<iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $book->youtube }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
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

			page_select('books', 'books');

		});

	</script>

@endsection