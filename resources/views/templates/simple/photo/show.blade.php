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

				<h4><strong>{{ $photo->name }}</strong></h4>

				@if($photo->price != null) <p class="small">Price: {{ $photo->price or '' }}</p> @endIf

				@if(count($photo->albums) > 0)
					<p class="small">Albums:<br>
						@foreach($photo->albums AS $data)
							@if($data->album->status == 1)
								<a class="button" href="{{ url('albums').'/'.$data->album->id }}">{{ $data->album->name }}</a>
							@endIf
						@endforeach
					</p>
				@endIf

				@if(count($photo->categories) > 0)
					<p class="small">Categories:<br>
						@foreach($photo->categories AS $data)
							@if($data->category->status == 1)
								<a class="button" href="javascript:void(0)">{{ $data->category->name }}</a>
							@endIf
						@endforeach
					</p>
				@endIf

				@if($photo->description != null) <p class="small">{{ $photo->description or '' }}</p> @endIf

				<p class="small">Share this photo</p>
				<div id="shareIcons"></div>

				<p class="small"><a onclick="window.history.back();" href="javascript:void(0)">Go back</a></p>
			</div>

			<div class="column column-span-2 column-push-0 column-last">

				<img src="{{ url('uploads/photos/full').'/'.$photo->image }}" alt="{{ $photo->name }}" />
				
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

			page_select('albums', 'categories');

		});

	</script>

@endsection