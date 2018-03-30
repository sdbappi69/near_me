<?php

namespace App\Modules\Album\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
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

class AlbumController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Album::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
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
        $albums = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Album::index", compact('albums', 'sizes'));
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
        return view("Album::create", compact('sizes', 'default_size'));
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

                $current_default_count = Album::whereDefault(true)->count();
                if($current_default_count == 0){
                    $default = 1;
                }else if($request->default == 1){
                    $current_default = Album::whereDefault(true)->first();
                    $current_default->default = 0;
                    $current_default->save();
                    $default = 1;
                }else{
                    $default = 0;
                }

                $last_album_count = Album::orderBy('priority', 'desc')->count();
                if($last_album_count > 0){
                    $last_album = Album::orderBy('priority', 'desc')->first();
                    $priority = $last_album->priority + 1;
                }else{
                    $priority = 1;
                }

                $album = new Album;
                $album->name = $request->name;
                $album->status = $request->status;
                $album->description = $request->description;
                $album->thumbnail_size_id = $request->thumbnail_size_id;
                $album->default = $default;
                $album->priority = $priority;

                $size = Size::findOrFail($request->thumbnail_size_id);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $url = 'uploads/photos/thumb/';
                $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                $album->image = $fileName;

                $album->created_by = Auth::id();
                $album->updated_by = Auth::id();
                $album->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new album is created',
            );
            Session::flash('message', $message);
            return Redirect('/albums');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new album',
            );
            Session::flash('message', $message);
            return Redirect('/albums');
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
        $album = Album::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Album::edit", compact('album', 'sizes'));
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

                $current_default_query = Album::whereDefault(true);
                if($current_default_query->count() == 0){
                    $default = 1;
                }else if($request->default == 1){
                    $current_default = $current_default_query->first();
                    $current_default->default = 0;
                    $current_default->save();
                    $default = 1;
                }else{
                    $default = 0;
                }

                $album = Album::findOrFail($id);
                $album->name = $request->name;
                $album->status = $request->status;
                $album->description = $request->description;
                $album->default = $default;

                if($request->hasFile('image')){
                    $album->thumbnail_size_id = $request->thumbnail_size_id;

                    $size = Size::findOrFail($request->thumbnail_size_id);
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $url = 'uploads/photos/thumb/';
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                    $album->image = $fileName;
                }

                $album->created_by = Auth::id();
                $album->updated_by = Auth::id();
                $album->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The album is updated',
            );
            Session::flash('message', $message);
            return Redirect('/albums');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update album',
            );
            Session::flash('message', $message);
            return Redirect('/albums');
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

                $album = Album::whereDefault(false)->where('id', $id)->delete();

                if($album){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the album',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That album can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/albums');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the album',
            );
            Session::flash('message', $message);
            return Redirect('/albums');
        }
    }

    public function up($id){
        try {
            DB::beginTransaction();

                $temp_album = Album::whereStatus(true)->where('id', $id)->first();
                $exchange_album = Album::whereStatus(true)->where('priority', '<', $temp_album->priority)->orderBy('priority', 'desc')->first();

                if($exchange_album && $temp_album){
                    $album_priority = $temp_album->priority;
                    $exchange_album_priority = $exchange_album->priority;

                    $temp_album->priority = 0;
                    $temp_album->save();

                    $exchange_album->priority = $album_priority;
                    $exchange_album->save();

                    $album = Album::findOrFail($id);
                    $album->priority = $exchange_album_priority;
                    $album->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the album',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That album can't be up",
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
                'text' => 'Failed to up the album',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id){
        try {
            DB::beginTransaction();

                $temp_album = Album::whereStatus(true)->where('id', $id)->first();
                $exchange_album = Album::whereStatus(true)->where('priority', '>', $temp_album->priority)->orderBy('priority', 'asc')->first();

                if($exchange_album && $temp_album){
                    $album_priority = $temp_album->priority;
                    $exchange_album_priority = $exchange_album->priority;

                    $temp_album->priority = 0;
                    $temp_album->save();

                    $exchange_album->priority = $album_priority;
                    $exchange_album->save();

                    $album = Album::findOrFail($id);
                    $album->priority = $exchange_album_priority;
                    $album->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the album',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That album can't be down",
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
                'text' => 'Failed to down the album',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }
}
