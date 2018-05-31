@extends('templates.simple.layouts.app')

@section('content')

	<!-- JS Social -->
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-plain.css" />

	<!-- Page base CSS -->
	<link rel="stylesheet" href="{{ URL::asset('templates/simple/asset/lc_lightbox.css') }}" />

	<!-- SKINS -->
	<link rel="stylesheet" href="{{ URL::asset('templates/simple/asset/minimal.css') }}" />

	<style type="text/css">
		/*! normalize.css v2.1.2 | MIT License | git.io/normalize */article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block}audio,canvas,video{display:inline-block}audio:not([controls]){display:none;height:0}[hidden]{display:none}html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}a:focus{outline:thin dotted}a:active,a:hover{outline:0}h1{font-size:2em;margin:.67em 0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:700}dfn{font-style:italic}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0}mark{background:#ff0;color:#000}code,kbd,pre,samp{font-family:monospace,serif;font-size:1em}pre{white-space:pre-wrap}q{quotes:"\201C" "\201D" "\2018" "\2019"}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-.5em}sub{bottom:-.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:0}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend{border:0;padding:0}button,input,select,textarea{font-family:inherit;font-size:100%;margin:0}button,input{line-height:normal}button,select{text-transform:none}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}input[type=search]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}input[type=search]::-webkit-search-cancel-button,input[type=search]::-webkit-search-decoration{-webkit-appearance:none}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}textarea{overflow:auto;vertical-align:top}table{border-collapse:collapse;border-spacing:0}

		.elem, .elem * {
			box-sizing: border-box;
			margin: 0 !important;	
		}
		.elem {
			display: inline-block;
			font-size: 0;
			width: 33%;
			border: 0px solid transparent;
			border-bottom: none;
			background: #;
			padding: 10px;
			height: auto;
			background-clip: padding-box;
		}
		.elem > span {
			display: block;
			cursor: pointer;
			height: 0;
			padding-bottom:	70%;
			background-size: cover;	
			background-position: center center;
		}
	</style>

	<!-- LIGHTBOX FADING SHOW/HIDE EFFECT (as explained in documentation) -->
	<style type="text/css">
		.lcl_fade_oc.lcl_pre_show #lcl_overlay,
		.lcl_fade_oc.lcl_pre_show #lcl_window,
		.lcl_fade_oc.lcl_is_closing #lcl_overlay,
		.lcl_fade_oc.lcl_is_closing #lcl_window {
			opacity: 1 !important;
		}
		.lcl_fade_oc.lcl_is_closing #lcl_overlay {
			-webkit-transition-delay: .15s !important; 
			transition-delay: .15s !important;
		}
		#lcl_overlay{
			opacity: 1 !important;
			}
	</style>

	<div class="container inner">
      	<div class="divide20"></div>
	    <div class="row">
	        <div class="col-sm-5">
	          <figure><img src="{{ url('/').'/uploads/photos/thumb/'.$album->image }}" alt="{{ $album->name }}"></figure>
	        </div>
	        <!-- /column -->
	        <div class="col-sm-7">
	           
	          	<h2>{{ $album->name }}</h2>
	          	@if($album->description != null) <p>{{ $album->description or '' }}</p> @endIf
	          	<div class="divide25"></div>
	          
	          	<a href="{{ url('albums') }}" class="btn btn-orange">Back to albums</a>

	          	<div id="shareIcons"></div>
	          
	        </div>
	        <!-- /column --> 
	        
	    </div>
	    <!-- /.row -->
	    <div class="clearfix"></div>

	    @if(count($photos) > 0)

		    <div class="container" style="margin-top: 50px;">
	    
				<div class="content">

					@foreach($photos AS $data)
			    
			   			<a class="elem" href="{{ url('uploads/photos/full').'/'.$data->photo->image }}" title="{{ $data->photo->name }}" data-lcl-txt="{{ $data->photo->description }}" data-lcl-author="{{ $setting->name }}" data-lcl-thumb="{{ url('uploads/photos/thumb').'/'.$data->photo->image }}">
				        	<span style="background-image:url({{ url('uploads/photos/thumb').'/'.$data->photo->image }})"></span>
				        </a>

			        @endforeach

			        <div class="pagination">
			            {{ $photos->appends($_REQUEST)->render() }}
			        </div>

			   	</div>

			</div>

		@endIf

    </div>
    <!--/.container --> 

	<!-- JS Social -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

	<!-- Page base CSS -->
	<script src="{{ URL::asset('templates/simple/asset/lc_lightbox.lite.js') }}" type="text/javascript"></script>

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('albums', 'albums-{{ $album->id }}');

			// live handler
			lc_lightbox('.elem', {
				wrap_class: 'lcl_fade_oc',
				gallery : true,	
				thumb_attr: 'data-lcl-thumb', 
				
				skin: 'minimal',
				radius: 0,
				padding	: 0,
				border_w: 0,
			});	

		});

	</script>

@endsection