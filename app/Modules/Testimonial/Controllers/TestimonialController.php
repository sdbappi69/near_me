<?php

namespace App\Modules\Testimonial\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Testimonial\Models\Testimonial;

use App\Modules\Theme\Models\Theme;
use App\Modules\Social\Models\Social;
use App\Modules\Setting\Models\Setting;
use App\Modules\Album\Models\Album;

use Validator;
use DB;
use Session;
use Redirect;
use File;
use Auth;
use Storage;
use Image;
use Exception;
use Entrust;

class TestimonialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('testimonial-view')) { abort(403); }

        $query = Testimonial::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('date') && !empty($request->date)){
            $query->where('date', 'like', '%'.$request->date.'%');
        }
        if($request->has('description') && !empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        if($request->has('status') && isset($request->status)){
            $query->where('status', $request->status);
        }
        if($request->has('thumbnail_size_id') && !empty($request->thumbnail_size_id)){
            $query->where('thumbnail_size_id', $request->thumbnail_size_id);
        }
        if($request->has('size_id') && !empty($request->size_id)){
            $query->where('size_id', $request->size_id);
        }
        $testimonials = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Testimonial::index", compact('testimonials', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('testimonial-create')) { abort(403); }

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        if($default_size){ $default_size_id = $default_size->id; }else{ $default_size_id = null; }
        return view("Testimonial::create", compact('sizes', 'default_size_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('testimonial-create')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'sometimes',
            'url' => 'sometimes',
            'video_url' => 'sometimes',
            'social_url' => 'sometimes',
            'youtube' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'image' => 'required|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $last_testimonial_query = Testimonial::orderBy('priority', 'desc');
                if($last_testimonial_query->count() > 0){
                    $last_testimonial = $last_testimonial_query->first();
                    $priority = $last_testimonial->priority + 1;
                }else{
                    $priority = 1;
                }

                $testimonial = new Testimonial;
                $testimonial->name = $request->name;
                $testimonial->date = $request->date;
                $testimonial->url = $request->url;
                $testimonial->video_url = $request->video_url;
                $testimonial->social_url = $request->social_url;
                $testimonial->youtube = $request->youtube;
                $testimonial->status = $request->status;
                $testimonial->description = $request->description;
                $testimonial->thumbnail_size_id = $request->thumbnail_size_id;
                $testimonial->size_id = $request->size_id;
                $testimonial->priority = $priority;

                $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                $size = Size::where('id', $request->size_id)->first();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $thumb_url = 'uploads/photos/thumb/';
                $url = 'uploads/photos/full/';
                $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                $testimonial->image = $fileName;

                $testimonial->created_by = Auth::id();
                $testimonial->updated_by = Auth::id();
                $testimonial->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new testimonial is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/testimonials');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new testimonial',
            );
            Session::flash('message', $message);
            return Redirect('/panel/testimonials');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Entrust::can('testimonial-update')) { abort(403); }

        $testimonial = Testimonial::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Testimonial::edit", compact('testimonial', 'sizes'));
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
        if(!Entrust::can('testimonial-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'sometimes',
            'url' => 'sometimes',
            'video_url' => 'sometimes',
            'social_url' => 'sometimes',
            'youtube' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'image' => 'sometimes|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $testimonial = Testimonial::findOrFail($id);
                $testimonial->name = $request->name;
                $testimonial->date = $request->date;
                $testimonial->url = $request->url;
                $testimonial->video_url = $request->video_url;
                $testimonial->social_url = $request->social_url;
                $testimonial->youtube = $request->youtube;
                $testimonial->status = $request->status;
                $testimonial->description = $request->description;

                if($request->hasFile('image')){
                    $testimonial->thumbnail_size_id = $request->thumbnail_size_id;
                    $testimonial->size_id = $request->size_id;

                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);

                    $testimonial->image = $fileName;
                }

                $testimonial->updated_by = Auth::id();
                $testimonial->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The testimonial is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/testimonials');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update testimonial',
            );
            Session::flash('message', $message);
            return Redirect('/panel/testimonials');
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
        if(!Entrust::can('testimonial-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $testimonial = Testimonial::where('id', $id)->delete();

                if($testimonial){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the testimonial',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That testimonial can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/testimonials');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the testimonial',
            );
            Session::flash('message', $message);
            return Redirect('/panel/testimonials');
        }
    }

    public function up($id)
    {
        if(!Entrust::can('testimonial-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_testimonial = Testimonial::whereStatus(true)->where('id', $id)->first();
                $exchange_testimonial = Testimonial::whereStatus(true)->where('priority', '<', $temp_testimonial->priority)->orderBy('priority', 'desc')->first();

                if($exchange_testimonial && $temp_testimonial){
                    $testimonial_priority = $temp_testimonial->priority;
                    $exchange_testimonial_priority = $exchange_testimonial->priority;

                    $temp_testimonial->priority = 0;
                    $temp_testimonial->save();

                    $exchange_testimonial->priority = $testimonial_priority;
                    $exchange_testimonial->save();

                    $testimonial = Testimonial::findOrFail($id);
                    $testimonial->priority = $exchange_testimonial_priority;
                    $testimonial->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the testimonial',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That testimonial can't be up",
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
                'text' => 'Failed to up the testimonial',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id)
    {
        if(!Entrust::can('testimonial-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_testimonial = Testimonial::whereStatus(true)->where('id', $id)->first();
                $exchange_testimonial = Testimonial::whereStatus(true)->where('priority', '>', $temp_testimonial->priority)->orderBy('priority', 'asc')->first();

                if($exchange_testimonial && $temp_testimonial){
                    $testimonial_priority = $temp_testimonial->priority;
                    $exchange_testimonial_priority = $exchange_testimonial->priority;

                    $temp_testimonial->priority = 0;
                    $temp_testimonial->save();

                    $exchange_testimonial->priority = $testimonial_priority;
                    $exchange_testimonial->save();

                    $testimonial = Testimonial::findOrFail($id);
                    $testimonial->priority = $exchange_testimonial_priority;
                    $testimonial->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the testimonial',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That testimonial can't be down",
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
                'text' => 'Failed to down the testimonial',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function view()
    {
        $theme = Theme::where('status', 1)->where('default', 1)->first();
        $setting = Setting::FindOrFail(1);
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->get();
        $socials = Social::whereStatus(true)->orderBy('priority', 'asc')->get();

        $testimonials = Testimonial::whereStatus(1)->orderBy('priority', 'asc')->paginate(5);

        return view('templates.'.$theme->folder.'.testimonial.index', compact('theme', 'setting', 'albums', 'socials', 'testimonials'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $theme = Theme::where('status', 1)->where('default', 1)->first();
        $setting = Setting::FindOrFail(1);
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->get();
        $socials = Social::whereStatus(true)->orderBy('priority', 'asc')->get();

        $testimonial = Testimonial::findOrFail($id);

        return view('templates.'.$theme->folder.'.testimonial.show', compact('theme', 'setting', 'albums', 'socials', 'testimonial'));
    }
}
