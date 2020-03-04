<?php

namespace App\Modules\Home\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\User\Models\User;
use App\Modules\History\Models\History;
use App\Modules\Type\Models\Type;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        $types = Type::whereStatus(true)->orderBy('title', 'asc')->pluck('title', 'id')->toArray();

    	if($request->has('radius')){
            $radius = $request->radius;
        }else{
        	$radius = 0;
        }

        if($request->has('type_id')){
            $type_id = $request->type_id;
        }else{
        	$type_id = "";
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

        if($request->has('radius') && $request->has('type_id')){

        	$curl = curl_init();

            $type = Type::findOrFail($type_id);
            $type_title = str_replace(" ", "_", strtolower($type->title));
            $place_api = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$latitude.",".$longitude."&radius=".$radius."&type=".$type_title."&keyword=".$keyword."&key=".config('app.google_api_key');

            try {

                curl_setopt_array($curl, array(
                  CURLOPT_URL => $place_api,
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

                DB::beginTransaction();

                    $history = new History;
                    $history->radius = $radius;
                    $history->type_id = $type_id;
                    $history->keyword = $keyword;
                    $history->latitude = $latitude;
                    $history->longitude = $longitude;
                    $history->response = $response;
                    $history->created_at = date("Y-m-d H:i:s");
                    $history->created_by = auth()->user()->id;
                    $history->updated_by = auth()->user()->id;
                    $history->save();

                DB::commit();

                return view('Home::dashboard', compact('types', 'response'));
                
            } catch (Exception $e) {

                DB::rollBack();
                
                return view('Home::dashboard', compact('types'));

            }

        }else{

        	return view('Home::dashboard', compact('types'));

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
