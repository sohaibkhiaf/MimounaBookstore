<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderId = $request->input('order_id');
        $orderStatusId = (int) $request->input('order_status_id');

        if ($orderId && $orderStatusId) {
            $order = Order::findOrFail($orderId);
            $currentStatusId = (int) $order->order_status_id;

            $allowedTransitions = [
                1 => [2, 4],
                2 => [3, 5],
            ];

            abort_unless(in_array($orderStatusId, $allowedTransitions[$currentStatusId] ?? [], true), 403, 'Conflict');

            $order->update(['order_status_id' => $orderStatusId]);
        }

        $tab = $request->input('tab', 'processing');

        $statusMap = [
            'delivering' => 2,
            'delivered' => 3,
            'canceled' => 4,
            'returned' => 5,
        ];

        $query = Order::where('order_status_id', $statusMap[$tab] ?? 1);
        $orders = isset($statusMap[$tab])
            ? $query->latest('updated_at')->paginate(10)->withQueryString()
            : $query->oldest('created_at')->paginate(10)->withQueryString();

        return view('admin/orders/index', [
            'tab' => $tab,
            'orders' => $orders,
            'statuses' => OrderStatus::all()->keyBy('id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/orders/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subtotal' => 'required|integer',
            'shipping' => 'required|integer',
            'shipping-region' => 'required|string',
            'shipping-address' => 'required|string',
            'shipping-type' => 'required|string',
            'shipping-name' => 'required|string',
            'shipping-phone' => 'required|string',
        ]);

        $items = [];
        for ($i = 0; $i < 5; $i++) {
            $bookTitle = $request->input('book-title-'.$i);
            $orderedQuantity = $request->input('quantity-ordered-'.$i);
            $unitPrice = $request->input('unit-price-'.$i);

            if ($bookTitle === null && $orderedQuantity === null && $unitPrice === null) {
                continue;
            }

            if ($bookTitle === null || $orderedQuantity === null || $unitPrice === null) {
                return back()->with('error', __('messages.error_empty_fields'));
            }

            $items[] = [
                'book_title' => $bookTitle,
                'quantity' => $orderedQuantity,
                'unit_price' => $unitPrice,
                'book_id' => null,
            ];
        }

        if (empty($items)) {
            return back()->with('error', __('messages.error_details_not_set'));
        }

        $order = Order::create([
            'user_id' => null,
            'order_status_id' => 1,
            'subtotal' => $data['subtotal'],
            'shipping' => $data['shipping'],
            'total' => $data['subtotal'] + $data['shipping'],
            'shipping_region' => $data['shipping-region'],
            'shipping_address' => $data['shipping-address'],
            'shipping_type' => $data['shipping-type'],
            'shipping_name' => $data['shipping-name'],
            'shipping_phone' => $data['shipping-phone'],
        ]);

        $order->orderDetails()->createMany($items);

        return to_route('admin.orders')->with('success', __('messages.success_order_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('admin/orders/show', ['order' => $order->load('orderDetails')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('admin/orders/edit', ['order' => $order->load('orderDetails')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'subtotal' => 'required|integer',
            'shipping' => 'required|integer',
            'shipping-region' => 'required|string',
            'shipping-address' => 'required|string',
            'shipping-type' => 'required|string',
            'shipping-name' => 'required|string',
            'shipping-phone' => 'required|string',
        ]);

        $order->update([
            'subtotal' => $data['subtotal'],
            'shipping' => $data['shipping'],
            'total' => $data['subtotal'] + $data['shipping'],
            'shipping_region' => $data['shipping-region'],
            'shipping_address' => $data['shipping-address'],
            'shipping_type' => $data['shipping-type'],
            'shipping_name' => $data['shipping-name'],
            'shipping_phone' => $data['shipping-phone'],
        ]);

        foreach ($order->orderDetails as $detail) {
            $detail->update([
                'book_title' => $request->input('book-title-'.$detail->id),
                'quantity' => $request->input('quantity-ordered-'.$detail->id),
                'unit_price' => $request->input('unit-price-'.$detail->id),
                'book_id' => null,
            ]);
        }

        return to_route('admin.orders')
            ->with('success', __('messages.success_order_updated', ['order_id' => $order->id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $orderId = $order->id;
        $order->delete();

        return to_route('admin.orders')
            ->with('success', __('messages.success_order_deleted', ['order_id' => $orderId]));
    }
}
