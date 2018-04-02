<?php

namespace App\Modules\Sale\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Sale\Models\Sale;
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

class SaleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Sale::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('product_id') && !empty($request->product_id)){
            $query->where('product_id', 'like', '%'.$request->product_id.'%');
        }
        if($request->has('price') && !empty($request->price)){
            $query->where('price', 'like', '%'.$request->price.'%');
        }
        if($request->has('description') && !empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        if($request->has('category_id') && !empty($request->category_id)){
            $query->where('category_id', $request->category_id);
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
        $sales = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $categories = Category::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Sale::index", compact('sales', 'sizes', 'categories'));
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
        $categories = Category::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_category = Category::whereStatus(true)->whereDefault(true)->first();
        return view("Sale::create", compact('sizes', 'default_size', 'categories', 'default_category'));
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
            'product_id' => 'sometimes',
            'price' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'category_id' => 'required',
            'images' => 'required|max:5000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $images = $request->file('images');
                foreach ($images as $key => $image) {
                    $last_photo_count = Sale::orderBy('priority', 'desc')->count();
                    if($last_photo_count > 0){
                        $last_photo = Sale::orderBy('priority', 'desc')->first();
                        $priority = $last_photo->priority + 1;
                    }else{
                        $priority = 1;
                    }

                    $photo = new Sale;
                    $photo->name = $request->name;
                    $photo->product_id = $request->product_id;
                    $photo->price = $request->price;
                    $photo->status = $request->status;
                    $photo->description = $request->description;
                    $photo->thumbnail_size_id = $request->thumbnail_size_id;
                    $photo->size_id = $request->size_id;
                    $photo->category_id = $request->category_id;
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

                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'New photos are uploaded',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sales');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new photo',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sales');
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
        $sale = Sale::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $categories = Category::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Sale::edit", compact('sale', 'sizes', 'categories'));
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
            'product_id' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'category_id' => 'required',
            'image' => 'sometimes|image|max:5000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $photo = Sale::findOrFail($id);
                $photo->name = $request->name;
                $photo->product_id = $request->product_id;
                $photo->price = $request->price;
                $photo->status = $request->status;
                $photo->description = $request->description;
                $photo->category_id = $request->category_id;

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

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The photo is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sales');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update photo',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sales');
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

                $sale = Sale::where('id', $id)->delete();

                if($sale){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the print sell',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That print sell can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/sales');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the print sell',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sales');
        }
    }

    public function up($id){
        try {
            DB::beginTransaction();

                $temp_sale = Sale::whereStatus(true)->where('id', $id)->first();
                $exchange_sale = Sale::whereStatus(true)->where('priority', '<', $temp_sale->priority)->orderBy('priority', 'desc')->first();

                if($exchange_sale && $temp_sale){
                    $sale_priority = $temp_sale->priority;
                    $exchange_sale_priority = $exchange_sale->priority;

                    $temp_sale->priority = 0;
                    $temp_sale->save();

                    $exchange_sale->priority = $sale_priority;
                    $exchange_sale->save();

                    $sale = Sale::findOrFail($id);
                    $sale->priority = $exchange_sale_priority;
                    $sale->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the print sell',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That print sell can't be up",
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
                'text' => 'Failed to up the print sell',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id){
        try {
            DB::beginTransaction();

                $temp_sale = Sale::whereStatus(true)->where('id', $id)->first();
                $exchange_sale = Sale::whereStatus(true)->where('priority', '>', $temp_sale->priority)->orderBy('priority', 'asc')->first();

                if($exchange_sale && $temp_sale){
                    $sale_priority = $temp_sale->priority;
                    $exchange_sale_priority = $exchange_sale->priority;

                    $temp_sale->priority = 0;
                    $temp_sale->save();

                    $exchange_sale->priority = $sale_priority;
                    $exchange_sale->save();

                    $sale = Sale::findOrFail($id);
                    $sale->priority = $exchange_sale_priority;
                    $sale->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the print sell',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That print sell can't be down",
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
                'text' => 'Failed to down the print sell',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }
}
