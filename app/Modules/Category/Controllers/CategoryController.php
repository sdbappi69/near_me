<?php

namespace App\Modules\Category\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Category\Models\Category;
use App\Modules\Photo\Models\PhotoCategory;
use App\Modules\Photo\Models\Photo;

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

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('category-view')) { abort(403); }

        $query = Category::orderBy('priority', 'asc');
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
        $categories = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Category::index", compact('categories', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('category-create')) { abort(403); }

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        return view("Category::create", compact('sizes', 'default_size'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('category-create')) { abort(403); }

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

                $current_default_query = Category::whereDefault(true);
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

                $last_category_query = Category::orderBy('priority', 'desc');
                if($last_category_query->count() > 0){
                    $last_category = $last_category_query->first();
                    $priority = $last_category->priority + 1;
                }else{
                    $priority = 1;
                }

                $category = new Category;
                $category->name = $request->name;
                $category->status = $request->status;
                $category->description = $request->description;
                $category->thumbnail_size_id = $request->thumbnail_size_id;
                $category->default = $default;
                $category->priority = $priority;

                $size = Size::findOrFail($request->thumbnail_size_id);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $url = 'uploads/photos/thumb/';
                $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                $category->image = $fileName;

                $category->created_by = Auth::id();
                $category->updated_by = Auth::id();
                $category->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new category is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/categories');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new category',
            );
            Session::flash('message', $message);
            return Redirect('/panel/categories');
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
        if(!Entrust::can('category-update')) { abort(403); }

        $category = Category::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $photos = Photo::whereStatus(true)->orderBy('priority', 'asc')->get();
        $current_photos = array();
        foreach($category->photos AS $data){
            $current_photos[] = $data->photo_id;
        }
        return view("Category::edit", compact('category', 'sizes', 'photos', 'current_photos'));
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
        if(!Entrust::can('category-update')) { abort(403); }

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

                $current_default_query = Category::whereDefault(true);
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

                $category = Category::findOrFail($id);
                $category->name = $request->name;
                $category->status = $request->status;
                $category->description = $request->description;
                $category->default = $default;

                if($request->hasFile('image')){
                    $category->thumbnail_size_id = $request->thumbnail_size_id;

                    $size = Size::findOrFail($request->thumbnail_size_id);
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $url = 'uploads/photos/thumb/';
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                    $category->image = $fileName;
                }

                $category->updated_by = Auth::id();
                $category->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The category is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/categories');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update category',
            );
            Session::flash('message', $message);
            return Redirect('/panel/categories');
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
        if(!Entrust::can('category-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $category = Category::whereDefault(false)->where('id', $id)->delete();

                if($category){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the category',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That category can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/categories');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the category',
            );
            Session::flash('message', $message);
            return Redirect('/panel/categories');
        }
    }

    public function up($id)
    {
        if(!Entrust::can('category-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_category = Category::whereStatus(true)->where('id', $id)->first();
                $exchange_category = Category::whereStatus(true)->where('priority', '<', $temp_category->priority)->orderBy('priority', 'desc')->first();

                if($exchange_category && $temp_category){
                    $category_priority = $temp_category->priority;
                    $exchange_category_priority = $exchange_category->priority;

                    $temp_category->priority = 0;
                    $temp_category->save();

                    $exchange_category->priority = $category_priority;
                    $exchange_category->save();

                    $category = Category::findOrFail($id);
                    $category->priority = $exchange_category_priority;
                    $category->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the category',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That category can't be up",
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
                'text' => 'Failed to up the category',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id)
    {
        if(!Entrust::can('category-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_category = Category::whereStatus(true)->where('id', $id)->first();
                $exchange_category = Category::whereStatus(true)->where('priority', '>', $temp_category->priority)->orderBy('priority', 'asc')->first();

                if($exchange_category && $temp_category){
                    $category_priority = $temp_category->priority;
                    $exchange_category_priority = $exchange_category->priority;

                    $temp_category->priority = 0;
                    $temp_category->save();

                    $exchange_category->priority = $category_priority;
                    $exchange_category->save();

                    $category = Category::findOrFail($id);
                    $category->priority = $exchange_category_priority;
                    $category->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the category',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That category can't be down",
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
                'text' => 'Failed to down the category',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function photo_up($photo_id, $category_id)
    {
        if(!Entrust::can('category-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_photo = PhotoCategory::where('photo_id', $photo_id)->where('category_id', $category_id)->first();
                $exchange_photo = PhotoCategory::where('category_id', $category_id)->where('priority', '<', $temp_photo->priority)->orderBy('priority', 'desc')->first();

                if($exchange_photo && $temp_photo){
                    $photo_priority = $temp_photo->priority;
                    $exchange_photo_priority = $exchange_photo->priority;

                    $temp_photo->priority = 0;
                    $temp_photo->save();

                    $exchange_photo->priority = $photo_priority;
                    $exchange_photo->save();

                    $photo = PhotoCategory::where('photo_id', $photo_id)->where('category_id', $category_id)->first();
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

    public function photo_down($photo_id, $category_id)
    {
        if(!Entrust::can('category-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_photo = PhotoCategory::where('photo_id', $photo_id)->where('category_id', $category_id)->first();
                $exchange_photo = PhotoCategory::where('category_id', $category_id)->where('priority', '>', $temp_photo->priority)->orderBy('priority', 'asc')->first();

                if($exchange_photo && $temp_photo){
                    $photo_priority = $temp_photo->priority;
                    $exchange_photo_priority = $exchange_photo->priority;

                    $temp_photo->priority = 0;
                    $temp_photo->save();

                    $exchange_photo->priority = $photo_priority;
                    $exchange_photo->save();

                    $photo = PhotoCategory::where('photo_id', $photo_id)->where('category_id', $category_id)->first();
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
        if(!Entrust::can('category-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'category_id' => 'required',
            'photo_ids' => 'sometimes',
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                if($request->has('photo_ids')){

                    $photo_categories = PhotoCategory::where('category_id', $request->category_id)->get();

                    $old_photos = array();
                    foreach ($photo_categories as $photo_category) {
                        $old_photos[] = $photo_category->photo_id;

                        if(!in_array($photo_category->photo_id, $request->photo_ids)){
                            $photo_category_delete = PhotoCategory::where('photo_id', $photo_category->photo_id)->where('category_id', $request->category_id)->delete();
                        }
                    }

                    foreach ($request->photo_ids as $photo_id) {

                        if(!in_array($photo_id, $old_photos)){

                            $last_photo_category_count = PhotoCategory::orderBy('priority', 'desc')->count();
                            if($last_photo_category_count > 0){
                                $last_photo_category = PhotoCategory::orderBy('priority', 'desc')->first();
                                $category_priority = $last_photo_category->priority + 1;
                            }else{
                                $category_priority = 1;
                            }

                            $photo_category = new PhotoCategory;
                            $photo_category->photo_id = $photo_id;
                            $photo_category->category_id = $request->category_id;
                            $photo_category->priority = $category_priority;
                            $photo_category->created_at = date("Y-m-d H:i:s");
                            $photo_category->updated_by = Auth::id();
                            $photo_category->created_by = Auth::id();
                            $photo_category->save();
                        }
                    }

                }else{
                    $photo_category_delete = PhotoCategory::where('category_id', $request->category_id)->delete();
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
}
