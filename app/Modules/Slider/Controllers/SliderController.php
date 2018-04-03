<?php

namespace App\Modules\Slider\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Slider\Models\Slider;

use Validator;
use DB;
use Session;
use Redirect;
use File;
use Auth;
use Storage;
use Image;
use Exception;

class SliderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Slider::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('description') && !empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        if($request->has('status') && !empty($request->status)){
            $query->where('status', $request->status);
        }
        if($request->has('size_id') && !empty($request->size_id)){
            $query->where('size_id', $request->size_id);
        }
        $sliders = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Slider::index", compact('sliders', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        return view("Slider::create", compact('sizes', 'default_size'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'size_id' => 'required',
            'image' => 'required|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $last_slider_query = Slider::orderBy('priority', 'desc');
                if($last_slider_query->count() > 0){
                    $last_slider = $last_slider_query->first();
                    $priority = $last_slider->priority + 1;
                }else{
                    $priority = 1;
                }

                $slider = new Slider;
                $slider->name = $request->name;
                $slider->url = $request->url;
                $slider->status = $request->status;
                $slider->description = $request->description;
                $slider->size_id = $request->size_id;
                $slider->priority = $priority;

                $size = Size::where('id', $request->size_id)->first();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $thumb_url = 'uploads/photos/thumb/';
                $url = 'uploads/photos/full/';
                $thumb = Image::make($request->file('image'))->resize(100, 100)->save($thumb_url.$fileName);
                $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                $slider->image = $fileName;

                $slider->created_by = Auth::id();
                $slider->updated_by = Auth::id();
                $slider->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new slider is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sliders');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new slider',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sliders');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Slider::edit", compact('slider', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'size_id' => 'required',
            'image' => 'sometimes|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $slider = Slider::findOrFail($id);
                $slider->name = $request->name;
                $slider->url = $request->url;
                $slider->status = $request->status;
                $slider->description = $request->description;

                if($request->hasFile('image')){
                    $slider->size_id = $request->size_id;
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('image'))->resize(100, 100)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);

                    $slider->image = $fileName;
                }

                $slider->updated_by = Auth::id();
                $slider->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The slider is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sliders');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update slider',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sliders');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

                $slider = Slider::where('id', $id)->delete();

                if($slider){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the slider',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That slider can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/sliders');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the slider',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sliders');
        }
    }

    public function up($id){
        try {
            DB::beginTransaction();

                $temp_slider = Slider::whereStatus(true)->where('id', $id)->first();
                $exchange_slider = Slider::whereStatus(true)->where('priority', '<', $temp_slider->priority)->orderBy('priority', 'desc')->first();

                if($exchange_slider && $temp_slider){
                    $slider_priority = $temp_slider->priority;
                    $exchange_slider_priority = $exchange_slider->priority;

                    $temp_slider->priority = 0;
                    $temp_slider->save();

                    $exchange_slider->priority = $slider_priority;
                    $exchange_slider->save();

                    $slider = Slider::findOrFail($id);
                    $slider->priority = $exchange_slider_priority;
                    $slider->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the slider',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That slider can't be up",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect::back();

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to up the slider',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id){
        try {
            DB::beginTransaction();

                $temp_slider = Slider::whereStatus(true)->where('id', $id)->first();
                $exchange_slider = Slider::whereStatus(true)->where('priority', '>', $temp_slider->priority)->orderBy('priority', 'asc')->first();

                if($exchange_slider && $temp_slider){
                    $slider_priority = $temp_slider->priority;
                    $exchange_slider_priority = $exchange_slider->priority;

                    $temp_slider->priority = 0;
                    $temp_slider->save();

                    $exchange_slider->priority = $slider_priority;
                    $exchange_slider->save();

                    $slider = Slider::findOrFail($id);
                    $slider->priority = $exchange_slider_priority;
                    $slider->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the slider',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That slider can't be down",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect::back();

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to down the slider',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }
}
