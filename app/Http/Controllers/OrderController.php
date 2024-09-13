<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Order acception view
    public function list()
    {
        // $orders = Order::select('orders.id', 'orders.status', 'orders.order_code', 'orders.created_at', 'users.name as user_name')
        //     ->leftJoin('users', 'orders.user_id', 'users.id')
        //     ->orderBy('orders.created_at', 'desc')
        //     ->get();

        // Groupby method from chatGPT
        $orders = Order::select(
            'orders.order_code',
            DB::raw('MAX(orders.created_at) as created_at'),
            DB::raw('MAX(orders.status) as status'),
            DB::raw('MAX(users.name) as user_name')
        )
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['orders.order_code', 'users.name'], 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('created_at', 'desc')
            ->groupBy('orders.order_code')
            ->get();


        // dd($orders[0]['user_name']);
        return view('admin.order.list', compact('orders'));
    }

    public function details($orderCode)
    {
        $order = Order::select('orders.count as order_count', 'orders.order_code as order_code', 'orders.created_at as created_at', 'products.name as product_name', 'products.id as product_id', 'products.stock as available_stock', 'products.price as product_price', 'products.image as product_image', 'users.name as user_name', 'users.nickname as user_nickname', 'users.phone as user_phone', 'users.email as user_email', 'users.address as user_address')
            ->leftJoin('products', 'orders.product_id', 'products.id')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->where('order_code', $orderCode)
            ->get();

        // Groupby method from chatGPT
        // $order = Order::select(
        //     'orders.count as order_count',
        //     'orders.order_code as order_code',
        //     'orders.created_at as created_at',
        //     'products.name as product_name',
        //     'products.price as product_price',
        //     'products.image as product_image',
        //     'users.name as user_name',
        //     'users.nickname as user_nickname',
        //     'users.phone as user_phone',
        //     'users.email as user_email',
        //     'users.address as user_address'
        // )
        //     ->leftJoin('products', 'orders.product_id', 'products.id')
        //     ->leftJoin('users', 'orders.user_id', 'users.id')
        //     ->where('orders.order_code', $orderCode)
        //     ->groupBy(
        //         'orders.count',
        //         'orders.order_code',
        //         'orders.created_at',
        //         'products.name',
        //         'products.price',
        //         'products.image',
        //         'users.name',
        //         'users.nickname',
        //         'users.phone',
        //         'users.email',
        //         'users.address'
        //     )
        //     ->get();


        $payslipData = PaymentHistory::where('order_code', $orderCode)->first();

        $confirmStatus = [];
        $status = true;

        foreach ($order as $items) {
            array_push($confirmStatus, $items->available_stock < $items->order_count ? false : true);
        }

        foreach ($confirmStatus as $item) {
            if ($item == false) {
                $status = false;
                break;
            }
        }

        return view('admin.order.details', compact('order', 'payslipData', 'status'));
    }

    // Change status using api (ajax, jquery) method
    public function changeStatus(Request $request)
    {
        // logger($request['order_code']);
        Order::where('order_code', $request['order_code'])->update([
            'status' => $request['status']
        ]);
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function confirmOrder(Request $request)
    {
        logger($request->all());
        Order::where('order_code', $request[0]['order_code'])->update([
            'status' => 1
        ]);

        foreach ($request->all() as $items) {
            Product::where('id', $items['product_id'])->decrement('stock', $items['order_count']);
        }
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function rejectOrder(Request $request)
    {
        Order::where('order_code', $request->order_code)->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function saleInfo(Request $request)
    {
        $soldItems =  Order::select(
            'orders.order_code',
            DB::raw('MAX(orders.created_at) as created_at'),
            DB::raw('MAX(orders.status) as status'),
            DB::raw('MAX(users.name) as user_name')
        )
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['orders.order_code', 'users.name'], 'like', '%' . request('searchKey') . '%');
            })
            ->when($request->statusFilter !== null && $request->statusFilter !== '', function ($query) use ($request) {
                // Apply the filter if statusFilter is provided
                $query->where('orders.status', $request->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->groupBy('orders.order_code')
            ->get();
        // dd($soldItems->toArray());
        return view('admin.order.saleInfo', compact('soldItems'));
    }
}
