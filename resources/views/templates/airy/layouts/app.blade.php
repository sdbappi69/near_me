<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<link rel="Shortcut Icon" type="image/ico" href="favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  
	<title>{{ $setting->name }}</title>
  
	<!-- CSS _____________________________________________-->
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/icomoon.css') }}" media="screen" />
	<link rel="stylesheet" href="{{ URL::asset('templates/airy/css/magnificpopup.css') }}" media="screen" />
	<link rel="stylesheet" href="{{ URL::asset('templates/airy/style.css') }}" media="screen" />

	<!-- Font Awesome -->
  	<link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.min.css') }}">

	<!-- Fixing Internet Explorer ______________________________________-->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<link rel="stylesheet" href="css/ie.css" />
	<![endif]-->

	<script src="{{ URL::asset('templates/airy/js/jquery.min.js') }}"></script>

	<style type="text/css">
		.jssocials-share-link { border-radius: 50%; font-size: 10px; }
		.custom_share_icon{
			text-align: center;
			padding: 8px;
			font-size: 15px;
		}
		.custom_share_icon:hover{
			color: #FFFFFF;
		}
		.small{
			padding-bottom: 0px;
			margin-top: 20px;
		}
		.pagination{
			text-align: center;
			padding-left: 0px;
		}
		.pagination li{
		    display: inline-block;
		    padding: 8px 16px;
		    text-decoration: none;
		    background-color: #222222;
		}
	</style>

</head>
<body>

	<!-- Loader _______________________________-->
	<!-- <div class="loadreveal"></div>
	<div id="loadscreen"><div id="loader"><span></span></div></div> -->

	<!-- HEADER _____________________________________________-->
	<header role="banner" id="header">
			
		<div class="wrapper">

			<!-- Logo __-->
			<h1 id="logo">
				<a href="{{ url('/') }}" rel="home"> 
					<img src="{{ url('uploads/photos/full').'/'.$setting->image }}" alt="{{ $setting->name }}" />
				</a>
			</h1>
		
			<!-- Main menu __-->
			<nav id="mainmenu" role="navigation">
			
				<div id="menu-burger"><i class="icon-menu"></i></div>
				<div id="menu">
					<ul>
						<li class="main-menu home"><a href="{{ url('home') }}">Home</a></li>
						@if(count($albums) > 0)
							<li class="main-menu albums menu-item-has-children"><a href="{{ url('albums') }}">Albums</a>
								<ul class="sub-menu">
									@foreach($albums AS $album)
										<li class="main-menu album-{{ $album->id }}"><a href="{{ url('albums').'/'.$album->id }}">{{ $album->name }}</a></li>
									@endforeach
								</ul>
							</li>
						@endIf
						<li class="main-menu print-sales"><a href="{{ url('print-sales') }}">Print Sell</a></li>
						<li class="main-menu sales"><a href="{{ url('sales') }}">Sell</a></li>
						<li class="main-menu tearsheets"><a href="{{ url('tearsheets') }}">Tearsheets</a></li>
						<li class="main-menu biographies"><a href="{{ url('biographies') }}">Biography</a></li>
						<li class="main-menu awards"><a href="{{ url('awards') }}">Awards</a></li>
						<li class="main-menu testimonials"><a href="{{ url('testimonials') }}">Testimonials</a></li>
						<li class="main-menu books"><a href="{{ url('books') }}">Books</a></li>
						<li class="main-menu videos"><a href="{{ url('videos') }}">Videos</a></li>
						<li class="main-menu contacts"><a href="{{ url('contacts') }}">Contact</a></li>
					</ul>
				</div>
			</nav>
		</div> <!-- END .wrapper -->
		
	</header>

	
	
	<!-- MAIN CONTENT SECTION  _____________________________________________-->
	<section id="content" role="main">
		
		@yield('content')

	</section>

	<footer id="footer" role="contentinfo">
		<p class="back-to-top"><a href="#header">Back to top ↑</a></p>
		<p class="copyright">{{ $setting->name }} &copy; {{ date('Y') }}</p>
		@if(count($socials) > 0)
			<ul class="social-icons">
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
		@endIf
	</footer>

	<!-- Javascripts ______________________________________-->
	<script src="{{ URL::asset('templates/airy/js/retina.min.js') }}"></script>
	<!-- include image popups -->
	<script src="{{ URL::asset('templates/airy/js/jquery.magnific-popup.min.js') }}"></script>
	<!-- include mousewheel plugin -->
	<script src="{{ URL::asset('templates/airy/js/jquery.mousewheel.min.js') }}"></script>
	<!-- include svg line drawing plugin -->
	<!-- <script src="{{ URL::asset('templates/airy/js/jquery.lazylinepainter.min.js') }}"></script> -->
	<!-- include custom script -->
	<script src="{{ URL::asset('templates/airy/js/scripts.js') }}"></script>

	<script type="text/javascript">
		// Page Select
	  	function page_select(menu_class, sub_menu_class){
		    $(".main-menu").removeClass("current_page_parent");
		    $("."+menu_class).addClass("current_page_parent");
		    $("."+sub_menu_class).addClass("current_page_parent");
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
