<?php

namespace App\Modules\Video\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Video\Models\Video;

use Validator;
use DB;
use Session;
use Redirect;
use File;
use Auth;
use Storage;
use Image;
use Exception;

class VideoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Video::orderBy('priority', 'asc');
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
        $videos = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Video::index", compact('videos', 'sizes'));
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
        return view("Video::create", compact('sizes', 'default_size'));
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
            'image' => 'required|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $last_video_query = Video::orderBy('priority', 'desc');
                if($last_video_query->count() > 0){
                    $last_video = $last_video_query->first();
                    $priority = $last_video->priority + 1;
                }else{
                    $priority = 1;
                }

                $video = new Video;
                $video->name = $request->name;
                $video->date = $request->date;
                $video->url = $request->url;
                $video->video_url = $request->video_url;
                $video->social_url = $request->social_url;
                $video->youtube = $request->youtube;
                $video->status = $request->status;
                $video->description = $request->description;
                $video->thumbnail_size_id = $request->thumbnail_size_id;
                $video->priority = $priority;

                $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $thumb_url = 'uploads/photos/thumb/';
                $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                $video->image = $fileName;

                $video->created_by = Auth::id();
                $video->updated_by = Auth::id();
                $video->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new video is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/videos');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new video',
            );
            Session::flash('message', $message);
            return Redirect('/panel/videos');
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
        $video = Video::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Video::edit", compact('video', 'sizes'));
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
            'image' => 'sometimes|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $video = Video::findOrFail($id);
                $video->name = $request->name;
                $video->date = $request->date;
                $video->url = $request->url;
                $video->video_url = $request->video_url;
                $video->social_url = $request->social_url;
                $video->youtube = $request->youtube;
                $video->status = $request->status;
                $video->description = $request->description;

                if($request->hasFile('image')){
                    $video->thumbnail_size_id = $request->thumbnail_size_id;

                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);

                    $video->image = $fileName;
                }

                $video->updated_by = Auth::id();
                $video->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The video is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/videos');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update video',
            );
            Session::flash('message', $message);
            return Redirect('/panel/videos');
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

                $video = Video::where('id', $id)->delete();

                if($video){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the video',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That video can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/videos');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the video',
            );
            Session::flash('message', $message);
            return Redirect('/panel/videos');
        }
    }

    public function up($id){
        try {
            DB::beginTransaction();

                $temp_video = Video::whereStatus(true)->where('id', $id)->first();
                $exchange_video = Video::whereStatus(true)->where('priority', '<', $temp_video->priority)->orderBy('priority', 'desc')->first();

                if($exchange_video && $temp_video){
                    $video_priority = $temp_video->priority;
                    $exchange_video_priority = $exchange_video->priority;

                    $temp_video->priority = 0;
                    $temp_video->save();

                    $exchange_video->priority = $video_priority;
                    $exchange_video->save();

                    $video = Video::findOrFail($id);
                    $video->priority = $exchange_video_priority;
                    $video->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the video',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That video can't be up",
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
                'text' => 'Failed to up the video',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id){
        try {
            DB::beginTransaction();

                $temp_video = Video::whereStatus(true)->where('id', $id)->first();
                $exchange_video = Video::whereStatus(true)->where('priority', '>', $temp_video->priority)->orderBy('priority', 'asc')->first();

                if($exchange_video && $temp_video){
                    $video_priority = $temp_video->priority;
                    $exchange_video_priority = $exchange_video->priority;

                    $temp_video->priority = 0;
                    $temp_video->save();

                    $exchange_video->priority = $video_priority;
                    $exchange_video->save();

                    $video = Video::findOrFail($id);
                    $video->priority = $exchange_video_priority;
                    $video->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the video',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That video can't be down",
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
                'text' => 'Failed to down the video',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }
}
