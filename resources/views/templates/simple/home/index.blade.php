@extends('templates.simple.layouts.app')

@section('content')

	<div class="tp-fullscreen-container revolution">
		@if(count($sliders) > 0)

			<div class="tp-fullscreen">
            	<ul>
					@foreach($sliders AS $slider)

						<li data-transition="fade">
		                    <img src="{{ url('/').'/uploads/photos/full/'.$slider->image }}" alt="{{ $slider->name }}" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat" />
		                </li>

					@endforeach
				</ul>
	            <div class="tp-bannertimer tp-bottom"></div>
	        </div>

		@endIf
        <!-- /.tp-fullscreen-container -->
    </div>
    <!-- /.revolution -->

	<script type="text/javascript">
		$(document).ready(function () {

			page_select('home', 'home');

		});

	</script>

@endsection