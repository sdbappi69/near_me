<?php

namespace App\Modules\Theme\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Theme\Models\Theme;

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

class ThemeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('theme-view')) { abort(403); }

        $query = Theme::orderBy('name', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('description') && !empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        if($request->has('status') && !empty($request->status)){
            $query->where('status', $request->status);
        }
        $themes = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Theme::index", compact('themes', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('theme-create')) { abort(403); }

        return view("Theme::create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('theme-create')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'folder' => 'required',
            'description' => 'sometimes',
            'image' => 'required|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $current_default_query = Theme::whereDefault(true);
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

                $theme = new Theme;
                $theme->name = $request->name;
                $theme->folder = $request->folder;
                $theme->status = $request->status;
                $theme->default = $default;
                $theme->description = $request->description;

                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $thumb_url = 'uploads/photos/thumb/';
                $thumb = Image::make($request->file('image'))->resize(100, 100)->save($thumb_url.$fileName);
                $theme->image = $fileName;

                $theme->created_by = Auth::id();
                $theme->updated_by = Auth::id();
                $theme->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new theme is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/themes');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new theme',
            );
            Session::flash('message', $message);
            return Redirect('/panel/themes');
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
        if(!Entrust::can('theme-update')) { abort(403); }

        $theme = Theme::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Theme::edit", compact('theme', 'sizes'));
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
        if(!Entrust::can('theme-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'folder' => 'required',
            'status' => 'required',
            'description' => 'sometimes',
            'image' => 'sometimes|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $current_default_query = Theme::whereDefault(true);
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

                $theme = Theme::findOrFail($id);
                $theme->name = $request->name;
                $theme->folder = $request->folder;
                $theme->status = $request->status;
                $theme->default = $default;
                $theme->description = $request->description;

                if($request->hasFile('image')){

                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $thumb = Image::make($request->file('image'))->resize(100, 100)->save($thumb_url.$fileName);

                    $theme->image = $fileName;
                }

                $theme->updated_by = Auth::id();
                $theme->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The theme is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/themes');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update theme',
            );
            Session::flash('message', $message);
            return Redirect('/panel/themes');
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
        if(!Entrust::can('theme-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $theme = Theme::whereDefault(false)->where('id', $id)->delete();

                if($theme){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the theme',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That theme can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/themes');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the theme',
            );
            Session::flash('message', $message);
            return Redirect('/panel/themes');
        }
    }
}
