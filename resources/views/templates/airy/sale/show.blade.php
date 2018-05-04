@extends('templates.airy.layouts.app')

@section('content')

	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/columns.min.css') }}" media="screen" />

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />
	<style type="text/css">
		input{
			color: #CCCCCC;
		}
		textarea{
			color: #CCCCCC;
		}
	</style>

	<div class="wrapper">
		<!-- WYSIWYG starts here __-->

		<div class="column-grid column-grid-3">

			<div class="column column-span-1 column-push-0 column-first">	

				<h2>Photo</h2>

				<h4><strong>{{ $photo->name }}</strong></h4>

				@if($photo->price != null) <p class="small">Price: {{ $photo->price or '' }}</p> @endIf

				@if($photo->category != null) <p class="small">Category: {{ $photo->category->name or '' }}</p> @endIf

				@if($photo->description != null) <p class="small">{{ $photo->description or '' }}</p> @endIf

				{{ Form::open(array('url' => 'order-sales')) }}

					{{ Form::hidden('id', $photo->id) }}

					<div class="form-group">
            			{{ Form::text('name', Input::old('name'), array('class' => 'form-control input-lg', 'placeholder' => 'Name*', 'required' => 'required', 'id' => 'name')) }}
            		</div>
            		<div class="form-group">
            			{{ Form::email('email', Input::old('email'), array('class' => 'form-control input-lg', 'placeholder' => 'Email*', 'required' => 'required', 'id' => 'email')) }}
            		</div>
            		<div class="form-group">
            			{{ Form::text('contact', Input::old('contact'), array('class' => 'form-control input-lg', 'placeholder' => 'Contact*', 'required' => 'required')) }}
            		</div>
            		<div class="form-group">
            			{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control input-lg', 'placeholder' => 'Remarks', 'rows' => '7')) }}
            		</div>
            		<div class="form-group">
            			<input style="margin-top: 10px;" type="submit" class="btn btn-info"  value="Send Request">
            		</div>

				{!! Form::close() !!}

				<p class="small">Share this photo</p>
				<div id="shareIcons"></div>

				<p class="small"><a href="{{ url('sales') }}">Go Back</a></p>
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

			page_select('sales', 'sales');

			$("#name").focus();

		});

	</script>

@endsection