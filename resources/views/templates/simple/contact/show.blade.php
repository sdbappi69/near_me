@extends('templates.simple.layouts.app')

@section('content')

	<div class="container inner2">
      <div class="row">
        <div class="col-sm-12 text-center">

          	<h2 class="section-title text-center">Get in Touch</h2>
          
            <div class="column column-span-2 column-push-0 column-last">
				<?php print $setting->description; ?>
			</div>
          
        </div>
        <!--/column -->
        
      </div>
      <!--/.row --> 
      
    </div>
    <!--/.container --> 

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('contacts', 'contacts');

		});

	</script>

@endsection