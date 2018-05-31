<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="style/images/favicon.png">
	<title>{{ $setting->name }}</title>
	<!-- Bootstrap core CSS -->
	<link href="{{ URL::asset('templates/simple/style/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('templates/simple/style/css/plugins.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('templates/simple/style.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('templates/simple/style/css/color/blue.css') }}" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Karla:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href="{{ URL::asset('templates/simple/style/type/icons.css') }}" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.min.css') }}">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="{{ URL::asset('templates/simple/style/js/jquery.min.js') }}"></script>

	<style type="text/css">
		.pagination{
			margin-top: 50px;
			text-align: center;
		}
		.jssocials-share-link { border-radius: 50%; font-size: 10px; }
	</style>

</head>
<body>
	<!-- <div id="preloader"><div class="textload">Loading</div><div id="status"><div class="spinner"></div></div></div> -->
	<main class="body-wrapper">
	    <div class="navbar solid dark">
	        <div class="navbar-header">
	            <div class="basic-wrapper">
	                <div class="navbar-brand">
	                	<a href="{{ url('/') }}">
	                		<img src="#" srcset="{{ url('uploads/photos/full').'/'.$setting->image }} 1x, {{ url('uploads/photos/full').'/'.$setting->image }} 2x" class="logo-light" alt="{{ $setting->name }}" />
	                		<img src="#" srcset="{{ url('uploads/photos/full').'/'.$setting->image }} 1x, {{ url('uploads/photos/full').'/'.$setting->image }} 2x" class="logo-dark" alt="{{ $setting->name }}" />
	                	</a>
	            	</div>
	                <a class="btn responsive-menu" data-toggle="collapse" data-target=".navbar-collapse"><i></i></a>
	            </div>
	            <!-- /.basic-wrapper -->
	        </div>
	        <!-- /.navbar-header -->
	        <nav class="collapse navbar-collapse">

	            <ul class="nav navbar-nav">

	                <li class="main-menu home"><a href="{{ url('home') }}">Home</a></li>
	                <li class="main-menu albums"><a href="{{ url('albums') }}">Albums</a></li>
	                <li class="main-menu print-sales"><a href="{{ url('print-sales') }}">Print Sell</a></li>
	                <li class="main-menu sales"><a href="{{ url('sales') }}">Sell</a></li>
	                <li class="main-menu tearsheets"><a href="{{ url('tearsheets') }}">Tearsheets</a></li>
	                <li class="main-menu biographies"><a href="{{ url('biographies') }}">Biography</a></li>
	                <li class="main-menu awards"><a href="{{ url('awards') }}">Awards</a></li>
	                <li class="main-menu testimonialz"><a href="{{ url('testimonials') }}">Testimonials</a></li>
	                <li class="main-menu books"><a href="{{ url('books') }}">Books</a></li>
	                <li class="main-menu videos"><a href="{{ url('videos') }}">Videos</a></li>
	                <li class="main-menu contacts"><a href="{{ url('contacts') }}">Contact</a></li>

	            </ul>
	            <!-- /.navbar-nav -->
	        </nav>
	        <!-- /.navbar-collapse -->

	        @if(count($socials) > 0)
	        	<div class="social-wrapper">
					<ul class="social naked">
						@foreach($socials as $social)
							<li>
								<a href="{{ $social->url }}" target="_blank" title="{{ $social->name }}">
									@if($social->font_awesome != null)
										<i class="fa {{ $social->font_awesome }}"></i>
									@else
										<img src="{{ url('uploads/photos/full').'/'.$social->image }}" alt="{{ $social->name }}" style="width: 16px;">
									@endIf
								</a>
							</li>
						@endforeach						
					</ul>
					<!-- /.social -->
				</div>
				<!-- /.social-wrapper -->
			@endIf

	    </div>
	    <!-- /.navbar -->
	  
	  <div class="offset"></div>
	  <div class="light-wrapper">
	  
	        @yield('content')
	   
	    <!--/.container --> 
	  </div>
	  <!-- /.light-wrapper -->
	  
	  <!-- /.dark-wrapper -->
	  <footer class="footer inverse-wrapper">
	    
	    <!-- .container -->
	    
	    <div class="sub-footer">
	      <div class="container inner">
	        <p class="text-center">&copy; {{ date('Y') }} {{ $setting->name }}. All rights reserved. </p>
	      </div>
	      <!-- .container --> 
	    </div>
	    <!-- .sub-footer --> 
	  </footer>
	  <!-- /footer --> 
	  
	</main>
	<!--/.body-wrapper --> 
	<script src="{{ URL::asset('templates/simple/style/js/bootstrap.min.js') }}"></script> 
	<script src="{{ URL::asset('templates/simple/style/js/plugins.js') }}"></script> 
	<script src="{{ URL::asset('templates/simple/style/js/classie.js') }}"></script> 
	<script src="{{ URL::asset('templates/simple/style/js/jquery.themepunch.tools.min.js') }}"></script> 
	<script src="{{ URL::asset('templates/simple/style/js/scripts.js') }}"></script>

	<script type="text/javascript">
		// Page Select
	  	function page_select(menu_class, sub_menu_class){
		    $(".main-menu").removeClass("current");
		    $("."+menu_class).addClass("current");
		    $("."+sub_menu_class).addClass("current");
	  	}

	  	// Alert
	  	@if(Session::has('message'))
	  		<?php $message = Session::get('message'); ?>
	  		alert("{{ $message['text'] }}");
	  	@endif

	  	// Social Share Icons
	  	$("#shareIcons").jsSocials({
		    showLabel: false,
		    showCount: false,
		    shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest", "stumbleupon", "whatsapp"]
		});

	</script>

</body>
</html>