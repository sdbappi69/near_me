<?php

namespace App\Modules\History\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\User\Models\User;
use App\Modules\History\Models\History;
use App\Modules\Type\Models\Type;

use Validator;
use DB;
use Session;
use Redirect;
use Image;
use Auth;
use Entrust;

class HistoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('history-view')) { abort(403); }

        $types = Type::whereStatus(true)->orderBy('title', 'asc')->pluck('title', 'id')->toArray();

        $query = History::orderBy('id', 'desc');
        if($request->has('radius') && $request->radius != null){
            $query->where('radius', $request->radius);
        }
        if($request->has('type_id') && $request->type_id != null){
            $query->where('type_id', $request->type_id);
        }
        if($request->has('keyword') && $request->keyword != null){
            $query->where('keyword', 'like', '%'.$request->keyword.'%');
        }
        if($request->has('start_date') && $request->start_date != null){
            $start_date = $request->start_date;
        }else{
            $start_date = '2020-01-01';
        }
        if($request->has('end_date') && $request->end_date != null){
            $end_date = $request->end_date;
        }else{
            $end_date = date('Y-m-d');
        }
        $histories = $query->WhereBetween('created_at', array($start_date.' 00:00:01',$end_date.' 23:59:59'))
                        ->paginate(20);

        return view("History::index", compact('histories', 'types'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Entrust::can('history-view')) { abort(403); }

        $history = History::findOrFail($id);

        return view("History::view", compact('history'));

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
