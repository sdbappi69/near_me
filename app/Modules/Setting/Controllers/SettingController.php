<?php

namespace App\Modules\Setting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Setting\Models\Setting;

use App\Modules\Theme\Models\Theme;
use App\Modules\Social\Models\Social;
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
use Entrust;

class SettingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Entrust::can('setting')) { abort(403); }

        $setting = Setting::first();
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Setting::index", compact('setting', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('setting')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'sub_title' => 'sometimes',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'sometimes',
            'size_id' => 'required',
            'image' => 'sometimes|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $setting = Setting::findOrFail(1);
                $setting->name = $request->name;
                $setting->sub_title = $request->sub_title;
                $setting->email = $request->email;
                $setting->phone = $request->phone;
                $setting->description = $request->description;
                $setting->size_id = $request->size_id;

                if($request->hasFile('image')){
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $url = 'uploads/photos/full/';
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                    $setting->image = $fileName;
                }

                $setting->created_by = Auth::id();
                $setting->updated_by = Auth::id();
                $setting->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'Setting is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/settings');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update setting',
            );
            Session::flash('message', $message);
            return Redirect('/panel/settings');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $theme = Theme::where('status', 1)->where('default', 1)->first();
        $setting = Setting::FindOrFail(1);
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->get();
        $socials = Social::whereStatus(true)->orderBy('priority', 'asc')->get();

        return view('templates.'.$theme->folder.'.contact.show', compact('theme', 'setting', 'albums', 'socials'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
