<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaceOrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $rules = [
            'shippingType' => 'required|integer|in:1,2',
            'cartItems' => 'required|array|min:1',
            'cartItems.*.bookId' => 'required|integer|exists:books,id',
            'cartItems.*.bookTitle' => 'required|string',
            'cartItems.*.bookPrice' => 'required|integer',
            'cartItems.*.bookQuantity' => 'required|integer|min:1|max:5',
        ];

        $user = $request->user();

        if (! $user) {
            $rules = array_merge($rules, [
                'guestName' => 'required|string|max:50',
                'guestPhone' => 'required|string|size:10',
                'guestRegion' => 'required|integer|exists:regions,id',
                'guestAddress' => 'required|string|max:255',
            ]);
        }

        $data = $request->validate($rules);

        if ($user) {
            $user->loadMissing('region');
            $regionModel = $user->region;
            $shippingName = $user->name;
            $shippingPhone = $user->phone;
            $shippingAddress = $user->address;
            $userId = $user->id;
        } else {
            $regionModel = Region::findOrFail($data['guestRegion']);
            $shippingName = $data['guestName'];
            $shippingPhone = $data['guestPhone'];
            $shippingAddress = $data['guestAddress'];
            $userId = null;
        }

        if (! $regionModel->enabled) {
            return response()->json([
                'error' => true,
                'message' => __('messages.error_shipping_not_possible'),
            ]);
        }

        $cartItems = collect($data['cartItems']);
        $shippingType = (int) $data['shippingType'];

        $books = Book::whereIn('id', $cartItems->pluck('bookId'))->get()->keyBy('id');

        $subtotal = $cartItems->sum(function (array $item) use ($books) {
            $book = $books->get($item['bookId']);
            $unitPrice = $book->discount == 0 ? $book->price : $book->discount;

            return $unitPrice * $item['bookQuantity'];
        });

        $shipping = $shippingType === 1
            ? $regionModel->a_domicile
            : $regionModel->stop_desk;

        $locale = app()->getLocale();
        $type = $shippingType === 1
            ? match ($locale) {
                'ar' => 'التوصيل إلى المنزل',
                'fr' => 'Livraison à domicile',
                default => 'Home delivery',
            }
        : match ($locale) {
            'ar' => 'التوصيل إلى المكتب',
            'fr' => 'Livraison au bureau',
            default => 'Pick-up Desk',
        };

        $order = DB::transaction(function () use (
            $userId,
            $subtotal,
            $shipping,
            $regionModel,
            $shippingAddress,
            $type,
            $shippingName,
            $shippingPhone,
            $cartItems,
            $books
        ) {
            $order = Order::create([
                'user_id' => $userId,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $shipping + $subtotal,
                'shipping_region' => $regionModel->name,
                'shipping_address' => $shippingAddress,
                'shipping_type' => $type,
                'shipping_name' => $shippingName,
                'shipping_phone' => $shippingPhone,
                'order_status_id' => 1,
            ]);

            $detailsPayload = $cartItems->map(function (array $item) use ($books) {
                $book = $books->get($item['bookId']);

                return [
                    'book_title' => $book->title,
                    'quantity' => $item['bookQuantity'],
                    'unit_price' => $book->discount == 0 ? $book->price : $book->discount,
                    'book_id' => $book->id,
                ];
            })->all();

            $order->orderDetails()->createMany($detailsPayload);

            return $order;
        });

        if ($order) {
            return response()->json([
                'error' => false,
                'message' => __('messages.success_your_order_created'),
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => __('messages.error_unexpected'),
        ]);
    }
}
