<?php

namespace App\Modules\Size\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;

use Validator;
use DB;
use Session;
use Redirect;
use File;
use Auth;
use Storage;
use Exception;

class SizeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Size::orderBy('name', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('height') && !empty($request->height)){
            $query->where('height', 'like', '%'.$request->height.'%');
        }
        if($request->has('width') && !empty($request->width)){
            $query->where('width', 'like', '%'.$request->width.'%');
        }
        if($request->has('status') && !empty($request->status)){
            $query->where('status', $request->status);
        }
        $sizes = $query->paginate(20);
        return view("Size::index", compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Size::create");
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
            'width' => 'numeric|required',
            'height' => 'numeric|required'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $current_default_query = Size::whereDefault(true);
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

                $size = new Size;
                $size->name = $request->name;
                $size->status = $request->status;
                $size->width = $request->width;
                $size->height = $request->height;
                $size->default = $default;
                $size->created_by = Auth::id();
                $size->updated_by = Auth::id();
                $size->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new size is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sizes');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new size',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sizes');
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
        $size = Size::findOrFail($id);
        return view("Size::edit", compact('size'));
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
            'width' => 'numeric|required',
            'height' => 'numeric|required'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $current_default_query = Size::whereDefault(true);
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

                $size = Size::findOrFail($id);
                $size->name = $request->name;
                $size->status = $request->status;
                $size->width = $request->width;
                $size->height = $request->height;
                $size->default = $default;
                $size->updated_by = Auth::id();
                $size->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The size is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sizes');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update size',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sizes');
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

                $size = Size::whereDefault(false)->where('id', $id)->delete();

                if($size){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the size',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That size can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/sizes');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'This size is already in use',
            );
            Session::flash('message', $message);
            return Redirect('/panel/sizes');
        }
    }
}
