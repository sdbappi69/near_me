@extends('templates.airy.layouts.app')

@section('content')

	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/columns.min.css') }}" media="screen" />

	<div class="wrapper">

		<div class="column-grid column-grid-3">

			<div class="column column-span-1 column-push-0 column-first">
				<h3>{{ $setting->name or '' }}</h3>
				<h4><strong>{{ $setting->sub_title or '' }}</strong></h4>
				@if(isset($setting->email) && $setting->email != '')
					<p class="small">Email: {{ $setting->email or '' }}</p>
				@endIf
				@if(isset($setting->phone) && $setting->phone != '')
					<p class="small">Phone: {{ $setting->phone or '' }}</p>
				@endIf
			</div>

			<div class="column column-span-2 column-push-0 column-last">
				<?php print $setting->description; ?>
			</div>

		</div>

		<hr class="divider" />

	</div><!-- END .wrapper -->

	<!-- include Masonry -->
	<script src="{{ URL::asset('templates/airy/js/isotope.pkgd.min.js') }}"></script>

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('contacts', 'contacts');

		});

	</script>

@endsection