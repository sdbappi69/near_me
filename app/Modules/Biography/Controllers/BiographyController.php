<?php

namespace App\Modules\Biography\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Biography\Models\Biography;

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

class BiographyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('biography-view')) { abort(403); }

        $query = Biography::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('date') && !empty($request->date)){
            $query->where('date', 'like', '%'.$request->date.'%');
        }
        if($request->has('description') && !empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        if($request->has('status') && !empty($request->status)){
            $query->where('status', $request->status);
        }
        if($request->has('thumbnail_size_id') && !empty($request->thumbnail_size_id)){
            $query->where('thumbnail_size_id', $request->thumbnail_size_id);
        }
        if($request->has('size_id') && !empty($request->size_id)){
            $query->where('size_id', $request->size_id);
        }
        $biographies = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Biography::index", compact('biographies', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('biography-create')) { abort(403); }

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        if($default_size){ $default_size_id = $default_size->id; }else{ $default_size_id = null; }
        return view("Biography::create", compact('sizes', 'default_size_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('biography-create')) { abort(403); }

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

                $last_biography_query = Biography::orderBy('priority', 'desc');
                if($last_biography_query->count() > 0){
                    $last_biography = $last_biography_query->first();
                    $priority = $last_biography->priority + 1;
                }else{
                    $priority = 1;
                }

                $biography = new Biography;
                $biography->name = $request->name;
                $biography->date = $request->date;
                $biography->url = $request->url;
                $biography->video_url = $request->video_url;
                $biography->social_url = $request->social_url;
                $biography->youtube = $request->youtube;
                $biography->status = $request->status;
                $biography->description = $request->description;
                $biography->thumbnail_size_id = $request->thumbnail_size_id;
                $biography->size_id = $request->size_id;
                $biography->priority = $priority;

                $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                $size = Size::where('id', $request->size_id)->first();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $thumb_url = 'uploads/photos/thumb/';
                $url = 'uploads/photos/full/';
                $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                $biography->image = $fileName;

                $biography->created_by = Auth::id();
                $biography->updated_by = Auth::id();
                $biography->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new biography is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/biographies');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new biography',
            );
            Session::flash('message', $message);
            return Redirect('/panel/biographies');
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
        if(!Entrust::can('biography-update')) { abort(403); }

        $biography = Biography::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Biography::edit", compact('biography', 'sizes'));
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
        if(!Entrust::can('biography-update')) { abort(403); }

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

                $biography = Biography::findOrFail($id);
                $biography->name = $request->name;
                $biography->date = $request->date;
                $biography->url = $request->url;
                $biography->video_url = $request->video_url;
                $biography->social_url = $request->social_url;
                $biography->youtube = $request->youtube;
                $biography->status = $request->status;
                $biography->description = $request->description;

                if($request->hasFile('image')){
                    $biography->thumbnail_size_id = $request->thumbnail_size_id;
                    $biography->size_id = $request->size_id;

                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);

                    $biography->image = $fileName;
                }

                $biography->updated_by = Auth::id();
                $biography->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The biography is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/biographies');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update biography',
            );
            Session::flash('message', $message);
            return Redirect('/panel/biographies');
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
        if(!Entrust::can('biography-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $biography = Biography::where('id', $id)->delete();

                if($biography){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the biography',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That biography can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/biographies');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the biography',
            );
            Session::flash('message', $message);
            return Redirect('/panel/biographies');
        }
    }

    public function up($id)
    {
        if(!Entrust::can('biography-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_biography = Biography::whereStatus(true)->where('id', $id)->first();
                $exchange_biography = Biography::whereStatus(true)->where('priority', '<', $temp_biography->priority)->orderBy('priority', 'desc')->first();

                if($exchange_biography && $temp_biography){
                    $biography_priority = $temp_biography->priority;
                    $exchange_biography_priority = $exchange_biography->priority;

                    $temp_biography->priority = 0;
                    $temp_biography->save();

                    $exchange_biography->priority = $biography_priority;
                    $exchange_biography->save();

                    $biography = Biography::findOrFail($id);
                    $biography->priority = $exchange_biography_priority;
                    $biography->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the biography',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That biography can't be up",
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
                'text' => 'Failed to up the biography',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id)
    {
        if(!Entrust::can('biography-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_biography = Biography::whereStatus(true)->where('id', $id)->first();
                $exchange_biography = Biography::whereStatus(true)->where('priority', '>', $temp_biography->priority)->orderBy('priority', 'asc')->first();

                if($exchange_biography && $temp_biography){
                    $biography_priority = $temp_biography->priority;
                    $exchange_biography_priority = $exchange_biography->priority;

                    $temp_biography->priority = 0;
                    $temp_biography->save();

                    $exchange_biography->priority = $biography_priority;
                    $exchange_biography->save();

                    $biography = Biography::findOrFail($id);
                    $biography->priority = $exchange_biography_priority;
                    $biography->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the biography',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That biography can't be down",
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
                'text' => 'Failed to down the biography',
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

        $biographies = Biography::whereStatus(1)->orderBy('priority', 'asc')->paginate(5);

        return view('templates.'.$theme->folder.'.biography.index', compact('theme', 'setting', 'albums', 'socials', 'biographies'));
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

        $biography = Biography::findOrFail($id);

        return view('templates.'.$theme->folder.'.biography.show', compact('theme', 'setting', 'albums', 'socials', 'biography'));
    }
}
