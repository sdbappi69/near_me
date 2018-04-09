@extends('templates.airy.layouts.app')

@section('content')

	<div class="wrapper">
		<!-- WYSIWYG -->

		<div class="position-absolute">
			<h2 class="big no-margin"><strong>{{ $setting->name }}</strong></h2>
			<h2>{{ $setting->sub_title }}</h2><br />
		</div>
		

		<div class="gallery fullscreen-gallery">

			@if(count($sliders) > 0)

				@foreach($sliders AS $slider)

					<figure class="gallery-item landscapes">
						<header class='gallery-icon'>
							<a href="{{ $slider->url or 'javascript:void(0)' }}"><img src="{{ url('/').'/uploads/photos/full/'.$slider->image }}"  alt="{{ $slider->name }}" /></a>
						</header>	
						<figcaption class='gallery-caption'>
							<div class="entry-summary">
								<p>{{ $slider->description or '' }}</p>
							</div>
						</figcaption>
					</figure>

				@endforeach

			@endIf

		</div>

		<!-- END WYSIWYG -->
	</div><!-- END .wrapper -->

	<!-- include gallery cycle plugin -->
	<script src="{{ URL::asset('templates/airy/js/jquery.cycle.min.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function () {

			$('body').addClass('fullscreen');

			page_select('home', 'home');

		});

	</script>

@endsection