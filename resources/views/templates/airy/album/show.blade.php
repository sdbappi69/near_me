@extends('templates.airy.layouts.app')

@section('content')

	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/columns.min.css') }}" media="screen" />

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<div class="wrapper">
			<!-- WYSIWYG starts here __-->

			<div class="column-grid column-grid-3">
				<div class="column column-span-1 column-push-0 column-first">	

					<h2>Photo Story</h2>

					<h4><strong>{{ $album->name }}</strong></h4>

					@if($album->description != null) <p class="small">{{ $album->description or '' }}</p> @endIf

					<p class="small">Share this album</p>
					<div id="shareIcons"></div>

					<p class="small"><a href="{{ url('albums') }}">Back to albums</a></p>
				</div>
				<div class="column column-span-2 column-push-0 column-last">

					@if(count($categories) > 0)
						<nav id="gallery-filter">
							<ul>
								<li><a href="javascript:void(0)" data-filter="*" class="active">All</a></li>
								@foreach($categories AS $category)
									<li><a href='javascript:void(0)' data-filter='.{{ $category->id }}'>{{ $category->name }}</a></li>
								@endforeach
							</ul>
						</nav>
					@endIf

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
					@if(count($photos) > 0)
						<div class="gallery masonry-gallery">
							
							@foreach($photos AS $data)

								<figure class="gallery-item @if(count($data->photo->categories)) @foreach($data->photo->categories AS $photo_category) {{ $photo_category->category_id.' ' }} @endforeach @endIf">
									<header class='gallery-icon'>
										<a href="{{ url('uploads/photos/full').'/'.$data->photo->image }}" class="popup">
											<img src="{{ url('uploads/photos/thumb').'/'.$data->photo->image }}" alt="{{ $data->photo->name }}"/>
										</a>
									</header>	
									<figcaption class='gallery-caption'>
										<div class="entry-summary">
											<h3>{{ $data->photo->name }}</h3>
											<!-- <p>
												{{ $data->photo->description }}
											</p> -->
										</div>
									</figcaption>
									<a class="custom_share_icon pull-right" href="{{ url('photos').'/'.$data->photo_id }}">Photo Story <i class="fa fa-eye"></i></a>
								</figure>

							@endforeach

						</div>

						<div class="pagination">
				            {{ $photos->appends($_REQUEST)->render() }}
				        </div>
						
					@endIf

				</div>
			</div>

			<hr class="divider" />


			<!-- WYSIWYG ends here __-->
		</div><!-- END .wrapper -->

	<!-- include Masonry -->
	<script src="{{ URL::asset('templates/airy/js/isotope.pkgd.min.js') }}"></script>

	<!-- JS Social -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('albums', 'albums-{{ $album->id }}');

		});

	</script>

@endsection