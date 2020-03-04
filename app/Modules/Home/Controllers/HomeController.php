<?php

namespace App\Modules\Home\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\User\Models\User;

class HomeController extends Controller
{

    public function index(Request $request)
    {
    	if($request->has('radius')){
            $radius = $request->radius;
        }else{
        	$radius = 0;
        }

        if($request->has('type')){
            $type = $request->type;
        }else{
        	$type = "";
        }

        if($request->has('keyword')){
            $keyword = $request->keyword;
        }else{
        	$keyword = "";
        }

        if($request->has('latitude')){
            $latitude = $request->latitude;
        }else{
        	$latitude = auth()->user()->latitude;
        }

        if($request->has('longitude')){
            $longitude = $request->longitude;
        }else{
        	$longitude = auth()->user()->longitude;
        }

        if($request->has('radius') && $request->has('type')){

        	$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$latitude.",".$latitude."&radius=".$radius."&type=".$type."&keyword=".$keyword."&key=".config('app.google_api_key'),
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			));

			$response = curl_exec($curl);

			curl_close($curl);

			

        }else{

        	return view('Home::dashboard');

        }

        
    }

    public function update_location(Request $request)
    {
    	$user = User::where('id', auth()->user()->id)->where('status', 1)->first();
    	if($user){
    		$user->address = $request->address;
	    	$user->latitude = $request->latitude;
	    	$user->longitude = $request->longitude;
	    	$user->save();

	    	$status = "Success";
    	}else{
    		$status = "Failed";
    	}

    	$feedback['status'] = $status;
        return response($feedback, 200);
    }

}
