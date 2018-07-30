<?php

namespace App\Modules\Permission\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Permission\Models\Permission;

use Validator;
use DB;
use Session;
use Redirect;
use Entrust;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('permission-view')) { abort(403); }

        $query = Permission::orderBy('display_name', 'asc');
        if($request->has('name')){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('display_name')){
            $query->where('display_name', 'like', '%'.$request->display_name.'%');
        }
        if($request->has('description')){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        $permissions = $query->paginate(20);
        return view("Permission::index", compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('permission-create')) { abort(403); }

        return view("Permission::create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('permission-create')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:permissions',
            'display_name' => 'required',
            'description' => 'sometimes'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $permission = new Permission;
                $permission->name = $request->name;
                $permission->display_name = $request->display_name;
                if($request->has('description')){
                    $permission->description = $request->description;
                }
                $permission->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new permission is created',
            );
            Session::flash('message', $message);
            return Redirect('panel/permissions');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new permission',
            );
            Session::flash('message', $message);
            return Redirect('panel/permissions');
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
        if(!Entrust::can('permission-view')) { abort(403); }

        $permission = Permission::findOrFail($id);
        return view("Permission::show", compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Entrust::can('permission-update')) { abort(403); }

        $permission = Permission::findOrFail($id);
        return view("Permission::edit", compact('permission'));
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
        if(!Entrust::can('permission-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,'.$id,
            'display_name' => 'required',
            'description' => 'sometimes'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $permission = Permission::findOrFail($id);
                $permission->name = $request->name;
                $permission->display_name = $request->display_name;
                if($request->has('description')){
                    $permission->description = $request->description;
                }
                $permission->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The permission is updated',
            );
            Session::flash('message', $message);
            return Redirect('panel/permissions');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update the permission',
            );
            Session::flash('message', $message);
            return Redirect('panel/permissions');
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
        if(!Entrust::can('permission-delete')) { abort(403); }
        
        try {
            DB::beginTransaction();

                $roles_count = DB::table('permission_role')->where('permission_id', $id)->count();
                if($roles_count == 0){

                    $permission = Permission::where('id', $id)->delete();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the permission',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => 'Some roles are containing this permission',
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('panel/permissions');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the permission',
            );
            Session::flash('message', $message);
            return Redirect('panel/permissions');
        }
    }
}
