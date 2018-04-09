@extends('templates.airy.layouts.app')

@section('content')

	<div class="wrapper">
	
		<h2>Album Archive</h2>

		@if(count($albums) > 0)

		<nav id="grid-changer">
			<ul>
				<li class="col-3"><a href="javascript:void(0)" class="active">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
						<rect width="10" height="10" x="8"   y="8" />
					</svg>
				</a></li>
				<li class="col-5"><a href="javascript:void(0)">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
						<rect width="7" height="7" x="6"   y="6" />
						<rect width="7" height="7" x="14" y="6" />
						<rect width="7" height="7" x="6" y="14" />
						<rect width="7" height="7" x="14" y="14" />
					</svg>
				</a></li>
			</ul>
		</nav>
		
		<!-- Gallery __-->
		<div class="gallery masonry-gallery">
			
			@foreach($albums AS $album)

				<figure class="gallery-item">
					<header class='gallery-icon'>
						<a href="{{ url('/').'/albums/'.$album->id }}"><img src="{{ url('/').'/uploads/photos/thumb/'.$album->image }}" alt="{{ $album->name }}" /></a>
					</header>	
					<figcaption class='gallery-caption'>
						<div class="entry-summary">
							<h3>{{ $album->name }}</h3>
						</div>
					</figcaption>
				</figure>

			@endforeach
			
		</div>

		@endIf

	</div><!-- END .wrapper -->

	<!-- include Masonry -->
	<script src="{{ URL::asset('templates/airy/js/isotope.pkgd.min.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function () {

			page_select('albums', 'albums');

		});

	</script>

@endsection