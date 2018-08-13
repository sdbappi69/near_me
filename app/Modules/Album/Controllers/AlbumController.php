<?php

namespace App\Modules\Album\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Album\Models\Album;
use App\Modules\Photo\Models\PhotoAlbum;
use App\Modules\Photo\Models\Photo;
use App\Modules\Category\Models\Category;

use App\Modules\Theme\Models\Theme;
use App\Modules\Social\Models\Social;
use App\Modules\Setting\Models\Setting;

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

class AlbumController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('album-view')) { abort(403); }

        $query = Album::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
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
        if(!Entrust::can('album-create')) { abort(403); }

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
        if(!Entrust::can('album-create')) { abort(403); }

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
            return Redirect('/panel/albums');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new album',
            );
            Session::flash('message', $message);
            return Redirect('/panel/albums');
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
        if(!Entrust::can('album-update')) { abort(403); }

        $album = Album::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $photos = Photo::whereStatus(true)->orderBy('priority', 'asc')->get();
        $current_photos = array();
        foreach($album->photos AS $data){
            $current_photos[] = $data->photo_id;
        }
        return view("Album::edit", compact('album', 'sizes', 'photos', 'current_photos'));
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
        if(!Entrust::can('album-update')) { abort(403); }

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

                $album->updated_by = Auth::id();
                $album->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The album is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/albums');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update album',
            );
            Session::flash('message', $message);
            return Redirect('/panel/albums');
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
        if(!Entrust::can('album-delete')) { abort(403); }

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
            return Redirect('/panel/albums');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the album',
            );
            Session::flash('message', $message);
            return Redirect('/panel/albums');
        }
    }

    public function up($id)
    {
        if(!Entrust::can('album-update')) { abort(403); }

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

    public function down($id)
    {
        if(!Entrust::can('album-update')) { abort(403); }
        
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

    public function photo_up($photo_id, $album_id)
    {
        if(!Entrust::can('album-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_photo = PhotoAlbum::where('photo_id', $photo_id)->where('album_id', $album_id)->first();
                $exchange_photo = PhotoAlbum::where('album_id', $album_id)->where('priority', '<', $temp_photo->priority)->orderBy('priority', 'desc')->first();

                if($exchange_photo && $temp_photo){
                    $photo_priority = $temp_photo->priority;
                    $exchange_photo_priority = $exchange_photo->priority;

                    $temp_photo->priority = 0;
                    $temp_photo->save();

                    $exchange_photo->priority = $photo_priority;
                    $exchange_photo->save();

                    $photo = PhotoAlbum::where('photo_id', $photo_id)->where('album_id', $album_id)->first();
                    $photo->priority = $exchange_photo_priority;
                    $photo->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the photo',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That photo can't be up",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect::back();

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to up the photo',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function photo_down($photo_id, $album_id)
    {
        if(!Entrust::can('album-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_photo = PhotoAlbum::where('photo_id', $photo_id)->where('album_id', $album_id)->first();
                $exchange_photo = PhotoAlbum::where('album_id', $album_id)->where('priority', '>', $temp_photo->priority)->orderBy('priority', 'asc')->first();

                if($exchange_photo && $temp_photo){
                    $photo_priority = $temp_photo->priority;
                    $exchange_photo_priority = $exchange_photo->priority;

                    $temp_photo->priority = 0;
                    $temp_photo->save();

                    $exchange_photo->priority = $photo_priority;
                    $exchange_photo->save();

                    $photo = PhotoAlbum::where('photo_id', $photo_id)->where('album_id', $album_id)->first();
                    $photo->priority = $exchange_photo_priority;
                    $photo->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the photo',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That photo can't be down",
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
                'text' => 'Failed to down the photo',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function photos(Request $request)
    {
        if(!Entrust::can('album-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'album_id' => 'required',
            'photo_ids' => 'sometimes',
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                if($request->has('photo_ids')){

                    $photo_albums = PhotoAlbum::where('album_id', $request->album_id)->get();

                    $old_photos = array();
                    foreach ($photo_albums as $photo_album) {
                        $old_photos[] = $photo_album->photo_id;

                        if(!in_array($photo_album->photo_id, $request->photo_ids)){
                            $photo_album_delete = PhotoAlbum::where('photo_id', $photo_album->photo_id)->where('album_id', $request->album_id)->delete();
                        }
                    }

                    foreach ($request->photo_ids as $photo_id) {

                        if(!in_array($photo_id, $old_photos)){

                            $last_photo_album_count = PhotoAlbum::orderBy('priority', 'desc')->count();
                            if($last_photo_album_count > 0){
                                $last_photo_album = PhotoAlbum::orderBy('priority', 'desc')->first();
                                $album_priority = $last_photo_album->priority + 1;
                            }else{
                                $album_priority = 1;
                            }

                            $photo_album = new PhotoAlbum;
                            $photo_album->photo_id = $photo_id;
                            $photo_album->album_id = $request->album_id;
                            $photo_album->priority = $album_priority;
                            $photo_album->created_at = date("Y-m-d H:i:s");
                            $photo_album->updated_by = Auth::id();
                            $photo_album->created_by = Auth::id();
                            $photo_album->save();
                        }
                    }

                }else{
                    $photo_album_delete = PhotoAlbum::where('album_id', $request->album_id)->delete();
                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The photos are updated',
            );
            Session::flash('message', $message);
            return Redirect::Back();

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update photos',
            );
            Session::flash('message', $message);
            return Redirect::Back();
        }

    }

    public function view()
    {
        $theme = Theme::where('status', 1)->where('default', 1)->first();
        $setting = Setting::FindOrFail(1);
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->get();
        $socials = Social::whereStatus(true)->orderBy('priority', 'asc')->get();

        $album_list = Album::whereStatus(true)->orderBy('priority', 'asc')->paginate(12);

        return view('templates.'.$theme->folder.'.album.index', compact('theme', 'setting', 'albums', 'socials', 'album_list'));
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

        $album = Album::findOrFail($id);
        $categories = Category::whereStatus(true)->orderBy('priority', 'asc')->get();
        $photos = PhotoAlbum::where('album_id', $id)->orderBy('priority', 'asc')->paginate(12);

        return view('templates.'.$theme->folder.'.album.show', compact('theme', 'setting', 'albums', 'socials', 'album', 'categories', 'photos'));
    }
}
