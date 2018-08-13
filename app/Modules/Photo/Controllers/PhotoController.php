<?php

namespace App\Modules\Photo\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Photo\Models\Photo;
use App\Modules\Photo\Models\PhotoAlbum;
use App\Modules\Photo\Models\PhotoCategory;
use App\Modules\Album\Models\Album;
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

class PhotoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('photo-view')) { abort(403); }

        $query = Photo::select('photos.*')->orderBy('photos.priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('photos.name', 'like', '%'.$request->name.'%');
        }
        if($request->has('product_id') && !empty($request->product_id)){
            $query->where('photos.product_id', 'like', '%'.$request->product_id.'%');
        }
        if($request->has('price') && !empty($request->price)){
            $query->where('photos.price', 'like', '%'.$request->price.'%');
        }
        if($request->has('status') && isset($request->status)){
            $query->where('photos.status', $request->status);
        }
        if($request->has('thumbnail_size_id') && !empty($request->thumbnail_size_id)){
            $query->where('photos.thumbnail_size_id', $request->thumbnail_size_id);
        }
        if($request->has('album_id') && !empty($request->album_id)){
            $query->join('photo_album', 'photo_album.photo_id', '=', 'photos.id');
            $query->where('photo_album.album_id', $request->album_id);
        }
        if($request->has('category_id') && !empty($request->category_id)){
            $query->join('photo_category', 'photo_category.photo_id', '=', 'photos.id');
            $query->where('photo_category.category_id', $request->category_id);
        }
        if($request->has('size_id') && !empty($request->size_id)){
            $query->where('photos.size_id', $request->size_id);
        }
        $photos = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $categories = Category::whereStatus(true)->orderBy('priority', 'asc')->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Photo::index", compact('photos', 'sizes', 'categories', 'albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('photo-create')) { abort(403); }

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $albums = Album::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $categories = Category::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        if($default_size){ $default_size_id = $default_size->id; }else{ $default_size_id = null; }
        $default_album = Album::whereStatus(true)->whereDefault(true)->first();
        if($default_album){ $default_album_id = $default_album->id; }else{ $default_album_id = null; }
        $default_category = Category::whereStatus(true)->whereDefault(true)->first();
        if($default_category){ $default_category_id = $default_category->id; }else{ $default_category_id = null; }
        return view("Photo::create", compact('sizes', 'albums', 'categories', 'default_size_id', 'default_album_id', 'default_category_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('photo-create')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'product_id' => 'sometimes',
            'price' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'album_ids' => 'required',
            'category_ids' => 'required',
            'images' => 'required|max:5000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $images = $request->file('images');
                foreach ($images as $key => $image) {
                    $last_photo_count = Photo::orderBy('priority', 'desc')->count();
                    if($last_photo_count > 0){
                        $last_photo = Photo::orderBy('priority', 'desc')->first();
                        $priority = $last_photo->priority + 1;
                    }else{
                        $priority = 1;
                    }

                    $photo = new Photo;
                    $photo->name = $request->name;
                    $photo->product_id = $request->product_id;
                    $photo->price = $request->price;
                    $photo->status = $request->status;
                    $photo->description = $request->description;
                    $photo->thumbnail_size_id = $request->thumbnail_size_id;
                    $photo->size_id = $request->size_id;
                    $photo->priority = $priority;

                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $image->getClientOriginalExtension();

                    if(!in_array($extension, array("jpeg","jpg","bmp","png"))){
                        DB::rollBack();
                        $message = array(
                            'class' => 'warning',
                            'title' => 'Failed',
                            'text' => "File type is not supported. please provide jpeg, jpg, bmp or png",
                        );
                        Session::flash('message', $message);
                        return Redirect::back();
                    }

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($image)->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($image)->resize($size->width, $size->height)->save($url.$fileName);
                    $photo->image = $fileName;

                    $photo->created_by = Auth::id();
                    $photo->updated_by = Auth::id();
                    $photo->save();

                    foreach ($request->album_ids as $album_id) {

                        $last_photo_album_count = PhotoAlbum::orderBy('priority', 'desc')->count();
                        if($last_photo_album_count > 0){
                            $last_photo_album = PhotoAlbum::orderBy('priority', 'desc')->first();
                            $album_priority = $last_photo_album->priority + 1;
                        }else{
                            $album_priority = 1;
                        }

                        $photo_album = new PhotoAlbum;
                        $photo_album->photo_id = $photo->id;
                        $photo_album->album_id = $album_id;
                        $photo_album->priority = $album_priority;
                        $photo_album->created_at = date("Y-m-d H:i:s");
                        $photo_album->created_by = Auth::id();
                        $photo_album->updated_by = Auth::id();
                        $photo_album->save();
                    }

                    foreach ($request->category_ids as $category_id) {

                        $last_photo_category_count = PhotoCategory::orderBy('priority', 'desc')->count();
                        if($last_photo_category_count > 0){
                            $last_photo_category = PhotoCategory::orderBy('priority', 'desc')->first();
                            $category_priority = $last_photo_category->priority + 1;
                        }else{
                            $category_priority = 1;
                        }

                        $photo_category = new PhotoCategory;
                        $photo_category->photo_id = $photo->id;
                        $photo_category->category_id = $category_id;
                        $photo_category->priority = $category_priority;
                        $photo_category->created_at = date("Y-m-d H:i:s");
                        $photo_category->created_by = Auth::id();
                        $photo_category->updated_by = Auth::id();
                        $photo_category->save();
                    }

                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'New photos are uploaded',
            );
            Session::flash('message', $message);
            return Redirect('/panel/photos');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new photo',
            );
            Session::flash('message', $message);
            return Redirect('/panel/photos');
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
        if(!Entrust::can('photo-update')) { abort(403); }

        $photo = Photo::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $albums = Album::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $categories = Category::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $default_albums = array();
        foreach ($photo->albums as $photo_album) {
            $default_albums[] = $photo_album->album_id;
        }

        $default_categories = array();
        foreach ($photo->categories as $photo_category) {
            $default_categories[] = $photo_category->category_id;
        }

        return view("Photo::edit", compact('photo', 'sizes', 'albums', 'categories', 'default_albums', 'default_categories'));
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
        if(!Entrust::can('photo-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'product_id' => 'sometimes',
            'price' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'album_ids' => 'required',
            'category_ids' => 'required',
            'image' => 'sometimes|image|max:5000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $photo = Photo::findOrFail($id);
                $photo->name = $request->name;
                $photo->product_id = $request->product_id;
                $photo->price = $request->price;
                $photo->status = $request->status;
                $photo->description = $request->description;

                if($request->hasFile('image')){
                    $photo->thumbnail_size_id = $request->thumbnail_size_id;
                    $photo->size_id = $request->size_id;

                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                    $photo->image = $fileName;
                }

                $photo->updated_by = Auth::id();
                $photo->save();

                $old_albums = array();
                foreach ($photo->albums as $photo_album) {
                    $old_albums[] = $photo_album->album_id;

                    if(!in_array($photo_album->album_id, $request->album_ids)){
                        $photo_album_delete = PhotoAlbum::where('photo_id', $id)->where('album_id', $photo_album->album_id)->delete();
                    }
                }

                foreach ($request->album_ids as $album_id) {

                    if(!in_array($album_id, $old_albums)){
                        
                        $last_photo_album_count = PhotoAlbum::orderBy('priority', 'desc')->count();
                        if($last_photo_album_count > 0){
                            $last_photo_album = PhotoAlbum::orderBy('priority', 'desc')->first();
                            $album_priority = $last_photo_album->priority + 1;
                        }else{
                            $album_priority = 1;
                        }

                        $photo_album = new PhotoAlbum;
                        $photo_album->photo_id = $photo->id;
                        $photo_album->album_id = $album_id;
                        $photo_album->priority = $album_priority;
                        $photo_album->created_at = date("Y-m-d H:i:s");
                        $photo_album->updated_by = Auth::id();
                        $photo_album->created_by = Auth::id();
                        $photo_album->save();

                    }
                    
                }

                $old_categories = array();
                foreach ($photo->categories as $photo_category) {
                    $old_categories[] = $photo_category->category_id;

                    if(!in_array($photo_category->category_id, $request->category_ids)){
                        $photo_category_delete = PhotoCategory::where('photo_id', $id)->where('category_id', $photo_category->category_id)->delete();
                    }
                }

                foreach ($request->category_ids as $category_id) {

                    if(!in_array($category_id, $old_categories)){

                        $last_photo_category_count = PhotoCategory::orderBy('priority', 'desc')->count();
                        if($last_photo_category_count > 0){
                            $last_photo_category = PhotoCategory::orderBy('priority', 'desc')->first();
                            $category_priority = $last_photo_category->priority + 1;
                        }else{
                            $category_priority = 1;
                        }

                        $photo_category = new PhotoCategory;
                        $photo_category->photo_id = $photo->id;
                        $photo_category->category_id = $category_id;
                        $photo_category->priority = $category_priority;
                        $photo_category->created_at = date("Y-m-d H:i:s");
                        $photo_category->updated_by = Auth::id();
                        $photo_category->created_by = Auth::id();
                        $photo_category->save();
                    }
                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The photo is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/photos');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update photo',
            );
            Session::flash('message', $message);
            return Redirect('/panel/photos');
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
        if(!Entrust::can('photo-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $photo_album_delete = PhotoAlbum::where('photo_id', $id)->delete();
                $photo_category_delete = PhotoCategory::where('photo_id', $id)->delete();
                $photo = Photo::where('id', $id)->delete();

                if($photo){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the photo',
                    );
                }else{
                    DB::rollBack();
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That photo can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/photos');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the photo',
            );
            Session::flash('message', $message);
            return Redirect('/panel/photos');
        }
    }

    public function up($id)
    {
        if(!Entrust::can('photo-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_photo = Photo::whereStatus(true)->where('id', $id)->first();
                $exchange_photo = Photo::whereStatus(true)->where('priority', '<', $temp_photo->priority)->orderBy('priority', 'desc')->first();

                if($exchange_photo && $temp_photo){
                    $photo_priority = $temp_photo->priority;
                    $exchange_photo_priority = $exchange_photo->priority;

                    $temp_photo->priority = 0;
                    $temp_photo->save();

                    $exchange_photo->priority = $photo_priority;
                    $exchange_photo->save();

                    $photo = Photo::findOrFail($id);
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
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to up the photo',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id)
    {
        if(!Entrust::can('photo-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_photo = Photo::whereStatus(true)->where('id', $id)->first();
                $exchange_photo = Photo::whereStatus(true)->where('priority', '>', $temp_photo->priority)->orderBy('priority', 'asc')->first();

                if($exchange_photo && $temp_photo){
                    $photo_priority = $temp_photo->priority;
                    $exchange_photo_priority = $exchange_photo->priority;

                    $temp_photo->priority = 0;
                    $temp_photo->save();

                    $exchange_photo->priority = $photo_priority;
                    $exchange_photo->save();

                    $photo = Photo::findOrFail($id);
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

        $photo = Photo::findOrFail($id);

        return view('templates.'.$theme->folder.'.photo.show', compact('theme', 'setting', 'albums', 'socials', 'photo'));
    }
}
