<?php

namespace App\Modules\Award\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Award\Models\Award;

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

class AwardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Award::orderBy('priority', 'asc');
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
        $awards = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Award::index", compact('awards', 'sizes'));
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
        if($default_size){ $default_size_id = $default_size->id; }else{ $default_size_id = null; }
        return view("Award::create", compact('sizes', 'default_size_id'));
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

                $last_award_query = Award::orderBy('priority', 'desc');
                if($last_award_query->count() > 0){
                    $last_award = $last_award_query->first();
                    $priority = $last_award->priority + 1;
                }else{
                    $priority = 1;
                }

                $award = new Award;
                $award->name = $request->name;
                $award->date = $request->date;
                $award->url = $request->url;
                $award->video_url = $request->video_url;
                $award->social_url = $request->social_url;
                $award->youtube = $request->youtube;
                $award->status = $request->status;
                $award->description = $request->description;
                $award->thumbnail_size_id = $request->thumbnail_size_id;
                $award->size_id = $request->size_id;
                $award->priority = $priority;

                if($request->hasFile('image')){
                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                    $award->image = $fileName;
                }

                $award->created_by = Auth::id();
                $award->updated_by = Auth::id();
                $award->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new award is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/awards');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new award',
            );
            Session::flash('message', $message);
            return Redirect('/panel/awards');
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
        $award = Award::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Award::edit", compact('award', 'sizes'));
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

                $award = Award::findOrFail($id);
                $award->name = $request->name;
                $award->date = $request->date;
                $award->url = $request->url;
                $award->video_url = $request->video_url;
                $award->social_url = $request->social_url;
                $award->youtube = $request->youtube;
                $award->status = $request->status;
                $award->description = $request->description;

                if($request->hasFile('image')){
                    $award->thumbnail_size_id = $request->thumbnail_size_id;
                    $award->size_id = $request->size_id;

                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);

                    $award->image = $fileName;
                }

                $award->updated_by = Auth::id();
                $award->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The award is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/awards');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update award',
            );
            Session::flash('message', $message);
            return Redirect('/panel/awards');
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

                $award = Award::where('id', $id)->delete();

                if($award){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the award',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That award can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/awards');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the award',
            );
            Session::flash('message', $message);
            return Redirect('/panel/awards');
        }
    }

    public function up($id){
        try {
            DB::beginTransaction();

                $temp_award = Award::whereStatus(true)->where('id', $id)->first();
                $exchange_award = Award::whereStatus(true)->where('priority', '<', $temp_award->priority)->orderBy('priority', 'desc')->first();

                if($exchange_award && $temp_award){
                    $award_priority = $temp_award->priority;
                    $exchange_award_priority = $exchange_award->priority;

                    $temp_award->priority = 0;
                    $temp_award->save();

                    $exchange_award->priority = $award_priority;
                    $exchange_award->save();

                    $award = Award::findOrFail($id);
                    $award->priority = $exchange_award_priority;
                    $award->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the award',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That award can't be up",
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
                'text' => 'Failed to up the award',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id){
        try {
            DB::beginTransaction();

                $temp_award = Award::whereStatus(true)->where('id', $id)->first();
                $exchange_award = Award::whereStatus(true)->where('priority', '>', $temp_award->priority)->orderBy('priority', 'asc')->first();

                if($exchange_award && $temp_award){
                    $award_priority = $temp_award->priority;
                    $exchange_award_priority = $exchange_award->priority;

                    $temp_award->priority = 0;
                    $temp_award->save();

                    $exchange_award->priority = $award_priority;
                    $exchange_award->save();

                    $award = Award::findOrFail($id);
                    $award->priority = $exchange_award_priority;
                    $award->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the award',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That award can't be down",
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
                'text' => 'Failed to down the award',
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

        $awards = Award::whereStatus(1)->orderBy('priority', 'asc')->paginate(5);

        return view('templates.'.$theme->folder.'.award.index', compact('theme', 'setting', 'albums', 'socials', 'awards'));
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

        $award = Award::findOrFail($id);

        return view('templates.'.$theme->folder.'.award.show', compact('theme', 'setting', 'albums', 'socials', 'award'));
    }
}
