<?php

namespace App\Modules\Role\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Role;
use App\PermissionRole;
use App\Permission;

use Validator;
use DB;
use Session;
use Redirect;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Role::orderBy('display_name', 'asc');
        if($request->has('name')){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('display_name')){
            $query->where('display_name', 'like', '%'.$request->display_name.'%');
        }
        if($request->has('description')){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        $roles = $query->paginate(20);
        return view("Role::index", compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::orderBy('display_name', 'asc')->get();
        return view("Role::create", compact('permissions'));
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
            'name' => 'required|unique:roles',
            'display_name' => 'required',
            'description' => 'sometimes',
            'permissions' => 'sometimes|array'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $role = new Role;
                $role->name = $request->name;
                $role->display_name = $request->display_name;
                if($request->has('description')){
                    $role->description = $request->description;
                }
                $role->save();

                if($request->has('permissions') && count($request->permissions) > 0){
                    foreach ($request->permissions as $permission_id) {
                        $permission_role = new PermissionRole;
                        $permission_role->role_id = $role->id;
                        $permission_role->permission_id = $permission_id;
                        $permission_role->save();
                    }
                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new role is created',
            );
            Session::flash('message', $message);
            return Redirect('/roles');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new role',
            );
            Session::flash('message', $message);
            return Redirect('/roles');
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
        $role = Role::findOrFail($id);
        return view("Role::show", compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::orderBy('display_name')->get();

        $containing_permissions = array();
        foreach ($role->permissions as $permission_role) {
            $containing_permissions[] = $permission_role->permission_id;
        }

        return view("Role::edit", compact('role', 'permissions', 'containing_permissions'));
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
            'name' => 'required|unique:roles,name,'.$id,
            'display_name' => 'required',
            'description' => 'sometimes',
            'permissions' => 'sometimes|array'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $role = Role::findOrFail($id);
                $role->name = $request->name;
                $role->display_name = $request->display_name;
                if($request->has('description')){
                    $role->description = $request->description;
                }
                $role->save();

                $permissions = PermissionRole::where('role_id', $id)->delete();

                if($request->has('permissions') && count($request->permissions) > 0){

                    foreach ($request->permissions as $permission_id) {
                        $permission_role = new PermissionRole;
                        $permission_role->role_id = $role->id;
                        $permission_role->permission_id = $permission_id;
                        $permission_role->save();
                    }
                }

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The role is updated',
            );
            Session::flash('message', $message);
            return Redirect('/roles');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update the role',
            );
            Session::flash('message', $message);
            return Redirect('/roles');
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

                $users_count = DB::table('role_user')->where('role_id', $id)->count();
                if($users_count == 0){
                    $permissions = PermissionRole::where('role_id', $id)->delete();

                    $role = Role::where('id', $id)->delete();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the role',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => 'Some users are containing this role',
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/roles');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the role',
            );
            Session::flash('message', $message);
            return Redirect('/roles');
        }
    }
}
