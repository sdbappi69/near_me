<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Modules\Photo\Models\Photo;
use App\Modules\Biography\Models\Biography;
use App\Modules\Award\Models\Award;
use App\Modules\Testimonial\Models\Testimonial;
use App\Modules\Book\Models\Book;
use App\Modules\Video\Models\Video;
use App\Modules\PrintSale\Models\PrintSale;
use App\Modules\Sale\Models\Sale;
use App\Modules\Tearsheet\Models\Tearsheet;
use App\Modules\Size\Models\Size;
use App\Modules\Category\Models\Category;
use App\Modules\Album\Models\Album;
use App\Modules\Slider\Models\Slider;
use App\Modules\Theme\Models\Theme;
use App\Modules\Social\Models\Social;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photo = Photo::whereStatus(true)->count();
        $biography = Biography::whereStatus(true)->count();
        $award = Award::whereStatus(true)->count();
        $testimonial = Testimonial::whereStatus(true)->count();
        $book = Book::whereStatus(true)->count();
        $video = Video::whereStatus(true)->count();
        $printsale = PrintSale::whereStatus(true)->count();
        $sale = Sale::whereStatus(true)->count();
        $tearsheet = Tearsheet::whereStatus(true)->count();
        $size = Size::whereStatus(true)->count();
        $category = Category::whereStatus(true)->count();
        $album = Album::whereStatus(true)->count();
        $slider = Slider::whereStatus(true)->count();
        $theme = Theme::whereStatus(true)->count();
        $social = Social::whereStatus(true)->count();

        return view('home', compact('photo', 'biography', 'award', 'testimonial', 'book', 'video', 'printsale', 'sale', 'tearsheet', 'size', 'category', 'album', 'slider', 'theme', 'social'));
    }
}
