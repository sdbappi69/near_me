<?php

namespace App\Modules\Social\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Social\Models\Social;

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

class SocialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('social-view')) { abort(403); }

        $query = Social::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('url') && !empty($request->url)){
            $query->where('url', 'like', '%'.$request->url.'%');
        }
        if($request->has('status') && !empty($request->status)){
            $query->where('status', $request->status);
        }
        if($request->has('size_id') && !empty($request->size_id)){
            $query->where('size_id', $request->size_id);
        }
        $socials = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Social::index", compact('socials', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('social-create')) { abort(403); }

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        return view("Social::create", compact('sizes', 'default_size'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('social-create')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'sometimes',
            'status' => 'required',
            'font_awesome' => 'sometimes',
            'size_id' => 'required',
            'image' => 'required|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $last_social_query = Social::orderBy('priority', 'desc');
                if($last_social_query->count() > 0){
                    $last_social = $last_social_query->first();
                    $priority = $last_social->priority + 1;
                }else{
                    $priority = 1;
                }

                $social = new Social;
                $social->name = $request->name;
                $social->url = $request->url;
                $social->status = $request->status;
                $social->font_awesome = $request->font_awesome;
                $social->size_id = $request->size_id;
                $social->priority = $priority;

                $size = Size::where('id', $request->size_id)->first();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $url = 'uploads/photos/full/';
                $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                $social->image = $fileName;

                $social->created_by = Auth::id();
                $social->updated_by = Auth::id();
                $social->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new social is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/socials');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new social',
            );
            Session::flash('message', $message);
            return Redirect('/panel/socials');
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
        if(!Entrust::can('social-update')) { abort(403); }

        $social = Social::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Social::edit", compact('social', 'sizes'));
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
        if(!Entrust::can('social-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'sometimes',
            'status' => 'required',
            'font_awesome' => 'sometimes',
            'size_id' => 'required',
            'image' => 'sometimes|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $social = Social::findOrFail($id);
                $social->name = $request->name;
                $social->url = $request->url;
                $social->status = $request->status;
                $social->font_awesome = $request->font_awesome;

                if($request->hasFile('image')){
                    $social->size_id = $request->size_id;
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $url = 'uploads/photos/full/';
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);

                    $social->image = $fileName;
                }

                $social->updated_by = Auth::id();
                $social->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The social is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/socials');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update social',
            );
            Session::flash('message', $message);
            return Redirect('/panel/socials');
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
        if(!Entrust::can('social-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $social = Social::where('id', $id)->delete();

                if($social){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the social network',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "The social network can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/socials');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the social network',
            );
            Session::flash('message', $message);
            return Redirect('/panel/socials');
        }
    }

    public function up($id)
    {
        if(!Entrust::can('social-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_social = Social::whereStatus(true)->where('id', $id)->first();
                $exchange_social = Social::whereStatus(true)->where('priority', '<', $temp_social->priority)->orderBy('priority', 'desc')->first();

                if($exchange_social && $temp_social){
                    $social_priority = $temp_social->priority;
                    $exchange_social_priority = $exchange_social->priority;

                    $temp_social->priority = 0;
                    $temp_social->save();

                    $exchange_social->priority = $social_priority;
                    $exchange_social->save();

                    $social = Social::findOrFail($id);
                    $social->priority = $exchange_social_priority;
                    $social->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the social network',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "The social network can't be up",
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
                'text' => 'Failed to up the social network',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id)
    {
        if(!Entrust::can('social-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_social = Social::whereStatus(true)->where('id', $id)->first();
                $exchange_social = Social::whereStatus(true)->where('priority', '>', $temp_social->priority)->orderBy('priority', 'asc')->first();

                if($exchange_social && $temp_social){
                    $social_priority = $temp_social->priority;
                    $exchange_social_priority = $exchange_social->priority;

                    $temp_social->priority = 0;
                    $temp_social->save();

                    $exchange_social->priority = $social_priority;
                    $exchange_social->save();

                    $social = Social::findOrFail($id);
                    $social->priority = $exchange_social_priority;
                    $social->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the social network',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "The social network can't be down",
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
                'text' => 'Failed to down the social network',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }
}
