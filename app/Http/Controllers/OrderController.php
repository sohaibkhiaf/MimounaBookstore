<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get params
        $order_id = request()->input('order_id');
        $order_status_id = request()->input('order_status_id');

        // change order status
        if(isset($order_id) && isset($order_status_id)){

            $order = Order::find($order_id);
            $orderStatusId = $order->orderStatus->id;

            if( ($order_status_id == 2 && $orderStatusId == 1)
                || ($order_status_id == 3 && $orderStatusId == 2)
                || ($order_status_id == 4 && $orderStatusId == 1)
                || ($order_status_id == 5 && $orderStatusId == 2) ){
                Order::find($order_id)->update(['order_status_id' => $order_status_id]);
            }else{
                abort(403 , 'Conflict');
            }

        }

        // get tab param
        $tab = request()->input('tab');

        // get orders of the selected status
        if($tab == 'delivering'){
            $orders = Order::where('order_status_id' , '=' , 2)->orderBy('updated_at' , 'desc' )->paginate(10);
        }elseif($tab == 'delivered'){
            $orders = Order::where('order_status_id' , '=' , 3)->orderBy('updated_at' , 'desc')->paginate(10);
        }elseif($tab == 'canceled'){
            $orders = Order::where('order_status_id' , '=' , 4)->orderBy('updated_at' , 'desc')->paginate(10);
        }elseif($tab == 'returned'){
            $orders = Order::where('order_status_id' , '=' , 5)->orderBy('updated_at' , 'desc')->paginate(10);
        }else{ // processing
            $orders = Order::where('order_status_id' , '=' , 1)->orderBy('created_at' , 'asc' )->paginate(10);
        }

        // open orders view
        return view('admin/orders/index' , ['tab' => $tab , 'orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // open create order view
        return view('admin/orders/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate data
        $data = request()->validate([
            'subtotal' => 'required|integer',
            'shipping' => 'required|integer',
            'shipping-region' => 'required|string',
            'shipping-address' => 'required|string',
            'shipping-type' => 'required|string',
            'shipping-name' => 'required|string',
            'shipping-phone' => 'required|string',
        ]);

        // test order details
        // 0= no order details set / 1= valid order details / 2= missing fields
        $valid = 0;
        for($i = 0; $i < 5; $i++){
            $bookTitle = request()->input('book-title-'.$i);
            $orderedQuantity = request()->input('quantity-ordered-'.$i);
            $unitPrice = request()->input('unit-price-'.$i);

            if($bookTitle === null && $orderedQuantity === null && $unitPrice === null){continue;}
            elseif($bookTitle === null || $orderedQuantity === null || $unitPrice === null){$valid = 2; break;}
            else{ $valid = 1; }
        }
        if($valid === 0){
            return redirect()->back()->with('error' , __('messages.error_details_not_set'));
        }elseif($valid == 2){
            return redirect()->back()->with('error' , __('messages.error_empty_fields'));
        }

        // calculate total
        $total = $data['subtotal'] + $data['shipping'];

        // create order
        $order = Order::create([
            'user_id' => null,
            'order_status_id' => OrderStatus::find(1)->id,
            'subtotal' => $data['subtotal'],
            'shipping' => $data['shipping'],
            'total' => $total,
            'shipping_region' => $data['shipping-region'],
            'shipping_address' => $data['shipping-address'],
            'shipping_type' => $data['shipping-type'],
            'shipping_name' => $data['shipping-name'],
            'shipping_phone' => $data['shipping-phone'],
        ]);

        for($i = 0; $i < 5; $i++){

            $bookTitle = request()->input('book-title-'.$i);
            $orderedQuantity = request()->input('quantity-ordered-'.$i);
            $unitPrice = request()->input('unit-price-'.$i);

            if($bookTitle === null && $orderedQuantity === null && $unitPrice === null){
                continue;
            }else{
                OrderDetail::create([
                    'order_id' => $order->id,
                    'book_title' => $bookTitle,
                    'quantity' => $orderedQuantity,
                    'unit_price' => $unitPrice,
                    'book_id' => null,
                ]);
            }
        }

        // open orders view
        return redirect()->route('admin.orders')
            ->with('success' , __('messages.success_order_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // open show order view
        return view('admin/orders/show' , ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // open edit order view
        return view('admin/orders/edit' , ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // validate data
        $data = request()->validate([
            'subtotal' => 'required|integer',
            'shipping' => 'required|integer',
            'shipping-region' => 'required|string',
            'shipping-address' => 'required|string',
            'shipping-type' => 'required|string',
            'shipping-name' => 'required|string',
            'shipping-phone' => 'required|string',
        ]);

        // calculate new total
        $total = $data['subtotal'] + $data['shipping'];

        // update order
        $order->update([
            'subtotal' => $data['subtotal'],
            'shipping' => $data['shipping'],
            'total' => $total,
            'shipping_region' => $data['shipping-region'],
            'shipping_address' => $data['shipping-address'],
            'shipping_type' => $data['shipping-type'],
            'shipping_name' => $data['shipping-name'],
            'shipping_phone' => $data['shipping-phone'],
        ]);

        // update order details
        foreach($order->orderDetails as $detail){
            $bookTitle = request()->input('book-title-'.$detail->id);
            $orderedQuantity = request()->input('quantity-ordered-'.$detail->id);
            $unitPrice = request()->input('unit-price-'.$detail->id);

            $detail->update([
                'book_title' => $bookTitle,
                'quantity' => $orderedQuantity,
                'unit_price' => $unitPrice,
                'book_id' => null,
            ]);
        }

        // open orders view
        return redirect()->route('admin.orders')
            ->with('success' , __('messages.success_order_updated' , ['order_id' => $order->id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // delete order
        $order->delete();

        // open orders view
        return redirect()->route('admin.orders')
            ->with('success' , __('messages.success_order_deleted' , ['order_id' => $order->id]));
    }
}
