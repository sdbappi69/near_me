<?php

namespace App\Modules\PrintSale\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\PrintSale\Models\PrintSale;
use App\Modules\PrintSale\Models\OrderPrintSale;
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
use Entrust;

class OrderPrintSaleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('orderprintsell-view')) { abort(403); }

        $query = OrderPrintSale::orderBy('id', 'desc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('order_id') && !empty($request->order_id)){
            $query->where('order_id', 'like', '%'.$request->order_id.'%');
        }
        if($request->has('email') && !empty($request->email)){
            $query->where('email', 'like', '%'.$request->email.'%');
        }
        if($request->has('contact') && !empty($request->contact)){
            $query->where('contact', 'like', '%'.$request->contact.'%');
        }
        if($request->has('description') && !empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        $orders = $query->paginate(20);

        return view("PrintSale::order", compact('orders'));
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
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'contact' => 'required',
            'description' => 'sometimes'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $order = new OrderPrintSale;
                $order->name = $request->name;
                $order->order_id = time();
                $order->print_sale_id = $request->id;
                $order->email = $request->email;
                $order->contact = $request->contact;
                $order->description = $request->description;
                $order->status = 1;
                $order->created_at = date("Y-m-d H:i:s");
                $order->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'Request Sent Successfully',
            );
            Session::flash('message', $message);
            return Redirect::back();

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to send the request',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
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
        if(!Entrust::can('orderprintsell-delete')) { abort(403); }
        
        try {
            DB::beginTransaction();

                $print_sale = OrderPrintSale::where('id', $id)->delete();

                if($print_sale){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the order',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That order can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/order-print-sales');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the order',
            );
            Session::flash('message', $message);
            return Redirect('/panel/order-print-sales');
        }
    }
}
