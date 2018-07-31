@extends('layouts.app')

@section('content')

	<!-- Main content -->
    <section class="content">

    	<div class="row">

    		@permission('photo-view')
	    		<div class="col-md-2  animated bounceInDown">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3>{{ $photo }}</h3>

		              <p>Photos</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-picture-o"></i>
		            </div>
		            <a href="{{ url('panel/photos') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('biography-view')
		        <div class="col-md-2  animated bounceInDown">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3>{{ $biography }}</h3>

		              <p>Biography</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-file-text"></i>
		            </div>
		            <a href="{{ url('panel/biographies') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission
	        
	        @permission('award-view')
		        <div class="col-md-2  animated bounceInDown">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3>{{ $award }}</h3>

		              <p>Awards</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-angellist"></i>
		            </div>
		            <a href="{{ url('panel/awards') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('testimonial-view')
		        <div class="col-md-2  animated bounceInDown">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3>{{ $testimonial }}</h3>

		              <p>Testimonials</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-certificate"></i>
		            </div>
		            <a href="{{ url('panel/testimonials') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('book-view')
		        <div class="col-md-2  animated bounceInDown">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3>{{ $book }}</h3>

		              <p>Books</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-book"></i>
		            </div>
		            <a href="{{ url('panel/books') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('video-view')
		        <div class="col-md-2  animated bounceInDown">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3>{{ $video }}</h3>

		              <p>Videos</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-video-camera"></i>
		            </div>
		            <a href="{{ url('panel/videos') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

    		@permission('printsell-view')
	    		<div class="col-md-2  animated bounceInLeft">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3>{{ $printsale }}</h3>

		              <p>Print Sell</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-barcode"></i>
		            </div>
		            <a href="{{ url('panel/print-sale') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('sell-view')
		        <div class="col-md-2  animated bounceInLeft">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3>{{ $sale }}</h3>

		              <p>Sell</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-shopping-cart"></i>
		            </div>
		            <a href="{{ url('panel/sales') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('tearsheet-view')
		        <div class="col-md-2  animated bounceInLeft">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3>{{ $tearsheet }}</h3>

		              <p>Tearsheets</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-file-photo-o"></i>
		            </div>
		            <a href="{{ url('panel/tearsheets') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('size-view')
		        <div class="col-md-2  animated bounceInRight">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3>{{ $size }}</h3>

		              <p>Sizes</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-object-ungroup"></i>
		            </div>
		            <a href="{{ url('panel/sizes') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('category-view')
		        <div class="col-md-2  animated bounceInRight">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3>{{ $category }}</h3>

		              <p>Categories</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-clone"></i>
		            </div>
		            <a href="{{ url('panel/categories') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('album-view')
		        <div class="col-md-2  animated bounceInRight">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3>{{ $album }}</h3>

		              <p>Albums</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-folder-open"></i>
		            </div>
		            <a href="{{ url('panel/albums') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

    		@permission('slider-view')
	    		<div class="col-md-2 animated bounceInUp">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3>{{ $slider }}</h3>

		              <p>Sliders</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-map"></i>
		            </div>
		            <a href="{{ url('panel/sliders') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('theme-view')
		        <div class="col-md-2 animated bounceInUp">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3>{{ $theme }}</h3>

		              <p>Themes</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-sun-o"></i>
		            </div>
		            <a href="{{ url('panel/themes') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

	        @permission('social-view')
		        <div class="col-md-2 animated bounceInUp">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3>{{ $social }}</h3>

		              <p>Social Networks</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-share-alt"></i>
		            </div>
		            <a href="{{ url('panel/socials') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
		          </div>
		        </div>
		        <!-- ./col -->
	        @endpermission

    	</div>

    </section>

    <script type="text/javascript">
    	$(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('dashboard', 'dashboard', 'Dashboard', '');
		});
    </script>

@endsection
