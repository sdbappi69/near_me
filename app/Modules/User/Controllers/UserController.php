<?php

namespace App\Modules\User\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Role\Models\Role;
use App\Modules\Role\Models\RoleUser;
use App\Modules\User\Models\User;

use Validator;
use DB;
use Session;
use Redirect;
use Image;
use Auth;
use Entrust;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('user-view')) { abort(403); }

        $query = User::orderBy('name', 'asc')->where('id', '!=', Auth::id());
        if($request->has('name')){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('email')){
            $query->where('email', 'like', '%'.$request->email.'%');
        }
        $users = $query->paginate(20);
        return view("User::index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('user-create')) { abort(403); }

        $roles = Role::orderBy('display_name', 'asc')->get();
        return view("User::create", compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('user-create')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'image' => 'sometimes|image|max:1024',
            'roles' => 'sometimes|array',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'.'.$extension;
                    $url = 'uploads/users/';

                    $img = Image::make($request->file('image'))->resize(500, 500)->save($url.$fileName);
                    $user->image = $fileName;
                }else{
                    $user->image = 'default_avatar.png';
                }
                $user->save();

                if($request->has('roles') && count($request->roles) > 0){
                    foreach ($request->roles as $role_id) {
                        $role_user = new RoleUser;
                        $role_user->role_id = $role_id;
                        $role_user->user_id = $user->id;
                        $role_user->save();
                    }
                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new user is created',
            );
            Session::flash('message', $message);
            return Redirect('panel/users');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new user',
            );
            Session::flash('message', $message);
            return Redirect('panel/users');
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
        if(!Entrust::can('user-view')) { abort(403); }

        $user = User::findOrFail($id);
        return view("User::show", compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Entrust::can('user-update')) { abort(403); }

        $user = User::findOrFail($id);

        $containing_roles = array();
        if(count($user->roles) > 0){
            foreach ($user->roles as $role_user) {
                $containing_roles[] = $role_user->role_id;
            }
        }

        $roles = Role::orderBy('display_name')->get();

        return view("User::edit", compact('user', 'roles', 'containing_roles'));
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
        if(!Entrust::can('user-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'image' => 'sometimes|image|max:1024',
            'roles' => 'sometimes|array'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->email = $request->email;
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = str_replace(' ', '-', strtolower($request->name)).'.'.$extension;
                    $url = 'uploads/users/';

                    $img = Image::make($request->file('image'))->resize(500, 500)->save($url.$fileName);
                    $user->image = $fileName;
                }
                $user->save();

                $roles = RoleUser::where('user_id', $id)->delete();

                if($request->has('roles') && count($request->roles) > 0){

                    foreach ($request->roles as $role_id) {
                        $role_user = new RoleUser;
                        $role_user->role_id = $role_id;
                        $role_user->user_id = $user->id;
                        $role_user->save();
                    }
                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The user is updated',
            );
            Session::flash('message', $message);
            return Redirect('panel/users');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update the user',
            );
            Session::flash('message', $message);
            return Redirect('panel/users');
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
        if(!Entrust::can('user-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $roles = RoleUser::where('user_id', $id)->delete();

                $user = User::where('id', $id)->delete();

                $message = array(
                    'class' => 'success',
                    'title' => 'Success',
                    'text' => 'Successfully deleted the user',
                );

            DB::commit();

            Session::flash('message', $message);
            return Redirect('panel/users');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the user',
            );
            Session::flash('message', $message);
            return Redirect('panel/users');
        }
    }
}
