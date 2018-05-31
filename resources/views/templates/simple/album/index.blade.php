@extends('templates.simple.layouts.app')

@section('content')

	<div class="container inner2">
      <h3 class="section-title text-center">PHOTO STORIES</h3>
      <div class="divide30"></div>
      <div  class="image-grid col3">
        <div class="items-wrapper">

        	@if(count($album_list) > 0)
	          	<ul class="isotope items">

	          		@foreach($album_list AS $album)

	          			<li class="item">
				            <figure class="icon-overlay"><a href="{{ url('/').'/albums/'.$album->id }}" ><img src="{{ url('/').'/uploads/photos/thumb/'.$album->image }}" alt="{{ $album->name }}" /></a></figure>
				            <div class="slide-portfolio-item-info box">
				                <h4 class="post-title">{{ $album->name }}</h4>
				            </div>
			            </li>

	          		@endforeach
		            
		         </ul>
	         @endIf

        </div>

        <!--/.items-wrapper --> 
      </div>
      <!-- slide-portfolio -->

      	<div class="pagination">
        	{{ $album_list->appends($_REQUEST)->render() }}
    	</div>
      
    </div>
    <!-- /.container -->

	<script type="text/javascript">
		$(document).ready(function () {

			page_select('albums', 'albums');

		});

	</script>

@endsection