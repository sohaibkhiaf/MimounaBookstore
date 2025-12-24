<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class PlaceOrderController extends Controller
{

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'shippingType' => 'required|integer',
            'cartItems' => 'required|array',
            'cartItems.*.bookId' => 'required|integer',
            'cartItems.*.bookTitle' => 'required|string',
            'cartItems.*.bookPrice' => 'required|integer',
            'cartItems.*.bookQuantity' => 'required|integer|min:1|max:5',
        ]);

        // check shipping possibility
        if(!$request->user()->region->enabled){
            return response()->json(['error' => true , 'message'=> __('messages.error_shipping_not_possible')]);
        }

        $cartItems = $data['cartItems'];
        $shippingType = $data['shippingType'];

        /* calculate subtotal */
        $subtotal = 0;
        foreach($cartItems as $item){

            $bookId = $item['bookId'];
            $bookQuantity = $item['bookQuantity'];

            $book = Book::find($bookId);

            // increase subtotal
            if($book->discount == 0){
                $subtotal += $book->price*$bookQuantity;
            }else{
                $subtotal += $book->discount*$bookQuantity;
            }
        }

        /* deduce shipping */
        if($shippingType == 1){
            $shipping = $request->user()->region->a_domicile;
        }else{
            $shipping = $request->user()->region->stop_desk;
        }

        /* calculate total */
        $total = $shipping + $subtotal;

        /* shipping address */
        if(app()->getLocale() == 'ar'){
            $region = $request->user()->region->ar_name;
        }else{
            $region = $request->user()->region->fr_name;
        }

        $address = $request->user()->address;
        if($shippingType == 1){

            if(app()->getLocale() == 'ar'){
                $type = "التوصيل إلى المنزل" ;
            }elseif(app()->getLocale() == 'fr'){
                $type = 'Livraison à domicile';
            }else{
                $type = 'Home delivery';
            }

        }else{

            if(app()->getLocale() == 'ar'){
                $type = "التوصيل إلى المكتب" ;
            }elseif(app()->getLocale() == 'fr'){
                $type = 'Livraison au bureau';
            }else{
                $type = 'Pick-up Desk';
            }
        }
        $name = $request->user()->name;
        $phone = $request->user()->phone;

        $order = $request->user()->orders()->create([
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
            'shipping_region' => $region,
            'shipping_address' => $address,
            'shipping_type' => $type,
            'shipping_name' => $name,
            'shipping_phone' => $phone,
            'order_status_id' => OrderStatus::find(1)->id,
        ]);

        /* create order details */
        if($order){

            foreach($cartItems as $item){

                $bookId = $item['bookId'];
                $bookQuantity = $item['bookQuantity'];

                $book = Book::find($bookId);

                if($book->discount == 0){
                    $bookPrice = $book->price;
                }else{
                    $bookPrice = $book->discount;
                }

                $order->orderDetails()->create([
                    'book_title' => $book->title,
                    'quantity' => $bookQuantity,
                    'unit_price'=> $bookPrice,
                    'book_id' => $bookId,
                ]);
            }

            return response()->json(['error' => false , 'message'=> __('messages.success_your_order_created')]);

        }else{
            return response()->json(['error' => true , 'message'=> __('messages.error_unexpected')]);
        }

    }

}
