@extends('templates.airy.layouts.app')

@section('content')

	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/columns.min.css') }}" media="screen" />

	<div class="wrapper">
			<!-- WYSIWYG starts here __-->
			<h2>Photo Story</h2>

			<div class="column-grid column-grid-3">
				<div class="column column-span-1 column-push-0 column-first">		
					<h4><strong>{{ $album->name }}</strong></h4>
					<p class="small">{{ $album->description }}</p>
					<p class="small"><a href="{{ url('albums') }}">Back to albums</a></p>
				</div>
				<div class="column column-span-2 column-push-0 column-last">	
					<div class="gallery masonry-gallery no-margin">
				
						<figure class="gallery-item">
							<header class='gallery-icon popup'>
								<a href="http://localhost/photography/public/uploads/photos/full/slider-1-1523092583.jpg" class="popup"><img src="http://localhost/photography/public/uploads/photos/full/slider-1-1523092583.jpg"alt="" /></a>
							</header>
							<figcaption class='gallery-caption'>
								<div class="entry-summary">
									<h3>Caption of This Beauty</h3>
									<p>Description of an image</p>
								</div>
							</figcaption>
						</figure>	

						<figure class="gallery-item">
							<header class='gallery-icon popup'>
								<a href="http://localhost/photography/public/uploads/photos/thumb/album-1-1523080734.jpg" class="popup"><img src="http://localhost/photography/public/uploads/photos/thumb/album-1-1523080734.jpg"alt="" /></a>
							</header>	
							<figcaption class='gallery-caption'>
								<div class="entry-summary">
									<h3>Caption of This Beauty</h3>
									<p>Description of an image</p>
								</div>
							</figcaption>
						</figure>
						
					</div>

				</div>
			</div>

			<hr class="divider" />


			<!-- WYSIWYG ends here __-->
		</div><!-- END .wrapper -->

	<!-- include Masonry -->
	<script src="{{ URL::asset('templates/airy/js/isotope.pkgd.min.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function () {

			page_select('albums', 'albums-{{ $album->id }}');

		});

	</script>

@endsection