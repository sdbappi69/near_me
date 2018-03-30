<?php

namespace App\Modules\Photo\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Photo\Models\Photo;
use App\Modules\Album\Models\Album;
use App\Modules\Category\Models\Category;

use Validator;
use DB;
use Session;
use Redirect;
use File;
use Auth;
use Storage;
use Image;
use Exception;

class PhotoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Photo::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('product_id') && !empty($request->product_id)){
            $query->where('product_id', 'like', '%'.$request->product_id.'%');
        }
        if($request->has('price') && !empty($request->price)){
            $query->where('price', 'like', '%'.$request->price.'%');
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
        $photos = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Photo::index", compact('photos', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $albums = Album::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $categories = Category::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        $default_album = Album::whereStatus(true)->whereDefault(true)->first();
        $default_category = Category::whereStatus(true)->whereDefault(true)->first();
        return view("Photo::create", compact('sizes', 'albums', 'categories', 'default_size', 'default_album', 'default_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'product_id' => 'sometimes',
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

                    $rules = [
                        'image' => 'required|image|mimes:jpeg,bmp,png|size:5000' //5MB Max Size
                    ];

                    $v = Validator::make($image, $rules);

                    if ($v->fails()) {
                        return redirect()->back()->withInput()->withErrors($v);
                    }

                    $photo = new Photo;
                    $photo->name = $request->name;
                    $photo->product_id = $request->product_id;
                    $photo->status = $request->status;
                    $photo->description = $request->description;
                    $photo->thumbnail_size_id = $request->thumbnail_size_id;
                    $photo->size_id = $request->size_id;
                    $photo->priority = $priority;

                    $thumb_size = Size::findOrFail($request->thumbnail_size_id);
                    $size = Size::findOrFail($request->size_id);
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('images'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('images'))->resize($size->width, $size->height)->save($url.$fileName);
                    $photo->image = $fileName;

                    $photo->created_by = Auth::id();
                    $photo->updated_by = Auth::id();
                    $photo->save();

                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new photo is created',
            );
            Session::flash('message', $message);
            return Redirect('/photos');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new photo',
            );
            Session::flash('message', $message);
            return Redirect('/photos');
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
        $photo = Photo::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Photo::edit", compact('photo', 'sizes'));
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
            'image' => 'sometimes|image|max:5000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $current_default_query = Photo::whereDefault(true);
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

                $photo = Photo::findOrFail($id);
                $photo->name = $request->name;
                $photo->status = $request->status;
                $photo->description = $request->description;
                $photo->default = $default;

                if($request->hasFile('image')){
                    $photo->thumbnail_size_id = $request->thumbnail_size_id;

                    $size = Size::findOrFail($request->thumbnail_size_id);
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $url = 'uploads/photos/thumb/';
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                    $photo->image = $fileName;
                }

                $photo->created_by = Auth::id();
                $photo->updated_by = Auth::id();
                $photo->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The photo is updated',
            );
            Session::flash('message', $message);
            return Redirect('/photos');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update photo',
            );
            Session::flash('message', $message);
            return Redirect('/photos');
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

                $photo = Photo::whereDefault(false)->where('id', $id)->delete();

                if($photo){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the photo',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That photo can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/photos');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the photo',
            );
            Session::flash('message', $message);
            return Redirect('/photos');
        }
    }

    public function up($id){
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

    public function down($id){
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
}
