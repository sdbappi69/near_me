@extends('templates.simple.layouts.app')

@section('content')

	<div class="container inner">
   
      <div class="divide20"></div>
      <div class="cbp-panel">
        <div class="cbp cbp-onepage-grid">

        	@if(count($photos) > 0)

        		@foreach($photos AS $photo)

        			<div class="cbp-item"> <a class="cbp-caption fancybox-media" data-rel="portfolio" href="{{ url('uploads/photos/full').'/'.$photo->image }}">
			            <div class="cbp-caption-defaultWrap"> <img src="{{ url('uploads/photos/thumb').'/'.$photo->image }}" class="imgwidth" alt="" /> </div>
			            <div class="cbp-caption-activeWrap">
			              <div class="cbp-l-caption-alignCenter">
			                <div class="cbp-l-caption-body">
			                  <div class="cbp-l-caption-title"><span class="cbp-plus"></span></div>
			                </div>
			              </div>
			            </div>
			            <!--/.cbp-caption-activeWrap --> 
			            </a>
			        </div>
		          <!--/.cbp-item -->

        		@endforeach

        	@endIf
          
        </div>
        <!--/.cbp --> 

        <div class="pagination">
            {{ $photos->appends($_REQUEST)->render() }}
        </div>
        
      </div>
      <!--/.cbp-panel --> 
    </div>
    <!-- /.container --> 

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('tearsheets', 'tearsheets');

		});

	</script>

@endsection