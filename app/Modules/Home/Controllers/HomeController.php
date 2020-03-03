<?php

namespace App\Modules\Home\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\User\Models\User;

class HomeController extends Controller
{

    public function index()
    {
        return view('Home::dashboard');
    }

    public function update_location(Request $request)
    {
        return 1;
        // return $auth->user()->id;

    }

}
