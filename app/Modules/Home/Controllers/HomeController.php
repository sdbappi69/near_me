<?php

namespace App\Modules\Home\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
use App\Modules\Setting\Models\Setting;

class HomeController extends Controller
{

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

        return view('Home::dashboard', compact('photo', 'biography', 'award', 'testimonial', 'book', 'video', 'printsale', 'sale', 'tearsheet', 'size', 'category', 'album', 'slider', 'theme', 'social'));
    }

    public function view()
    {
        $theme = Theme::where('status', 1)->where('default', 1)->first();
        $setting = Setting::FindOrFail(1);
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->get();
        $socials = Social::whereStatus(true)->orderBy('priority', 'asc')->get();

        $sliders = Slider::whereStatus(true)->orderBy('priority', 'asc')->get();

        return view('templates.'.$theme->folder.'.home.index', compact('theme', 'setting', 'albums', 'socials', 'sliders'));
    }

}
