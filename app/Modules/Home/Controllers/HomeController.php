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
        return view('Home::dashboard');
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
