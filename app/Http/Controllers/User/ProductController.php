<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // to_route easily goto home everywhere when you click Fruitable text
    public function home()
    {
        return to_route('userHome');
    }

    // Product Details View
    public function details($id)
    {
        $product = Product::select('products.id', 'products.name', 'products.stock as available_items', 'products.image', 'products.price', 'products.description', 'categories.name as categories_name')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            ->where('products.id', $id)
            ->first();

        $productList =  Product::select('products.id', 'products.name', 'products.image', 'products.price', 'products.description', 'categories.name as categories_name')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            ->where('categories.name', $product['categories_name'])
            ->where('products.id', '!=', $product['id'])
            ->get();

        $comments = Comment::select('comments.*','users.id as user_id', 'users.name as user_name', 'users.profile as user_profile')
            ->leftJoin('users', 'comments.user_id', 'users.id')
            ->where('product_id', $id)
            ->orderBy('comments.created_at', 'desc')
            ->get();

        $rating = Rating::where('product_id', $id)->avg('count');

        $user_rating = Rating::where('product_id', $id)->where('user_id', Auth::user()->id)->first('count');

        $user_rating = $user_rating == null ? 0 : $user_rating['count'];

        // ActionLog
        $this->actionLogAdd(Auth::user()->id, $id, 'seen');

        $viewCount = ActionLog::where('post_id', $id)->where('action', 'seen')->get();

        return view('user.home.details', compact('product', 'productList', 'comments', 'rating', 'user_rating', 'viewCount'));
    }

    public function addToCart(Request $request)
    {
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->count
        ]);

        // ActionLog
        $this->actionLogAdd($request->userId, $request->productId, 'addToCart');

        return to_route('userHome');
    }

    public function cartPage()
    {
        $cart = Cart::select('products.id as products_id', 'carts.id as carts_id', 'products.image', 'products.name', 'products.price', 'carts.qty')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        $total = 0;
        foreach ($cart as $items) {
            $total += $items->price * $items->qty;
        }
        return view('user.home.cart', compact('cart', 'total'));
    }

    public function cartDelete(Request $request)
    {
        $cartId = $request->cartId;
        Logger($cartId);
        Cart::where('id', $cartId)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Remove this item!'
        ], 200);
    }

    public function productList()
    {
        $product = Product::get();
        return response()->json($product, 200);
    }

    // Temp data for order cart
    public function cartTemp(Request $request)
    {
        $orderAry = [];
        foreach ($request->all() as $items) {
            array_push($orderAry, [
                'user_id' => $items['user_id'],
                'product_id' => $items['product_id'],
                'count' => $items['qty'],
                'order_code' => $items['order_code'],
                'total_ammount' => $items['total_ammount'],
                'status' => 0
            ]);
        }
        Session::put('tempCart', $orderAry);
        return response()->json([
            'status' => 'success',
            'message' => 'Order Success!'
        ], 200);
    }

    // Order confirm
    public function payment()
    {
        $payment = Payment::orderBy('type', 'desc')->get();
        $orderProduct = Session::get('tempCart');
        return view('user.home.payment', compact('payment', 'orderProduct'));
    }

    // Order Now
    public function order(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'paymentType' => 'required',
            'payslipImage' => 'required'
        ]);

        $paymentHistoryData = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount
        ];

        if ($request->hasFile('payslipImage')) {
            $fileName = uniqid() . $request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move(public_path() . '/payslip/', $fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);

        // Order and clear cart
        $orderProduct = Session::get('tempCart');

        foreach ($orderProduct as $items) {
            Order::create([
                'user_id' => $items['user_id'],
                'product_id' => $items['product_id'],
                'count' => $items['count'],
                'status' => $items['status'],
                'order_code' => $items['order_code']
            ]);


            Cart::where('user_id', $items['user_id'])->where('product_id', $items['product_id'])->delete();
            // dd('Order success');
        }
        return to_route('product#orderList');
    }

    public function orderList()
    {
        // $myOrder = Order::where('user_id', Auth::user()->id)
        //     // ->groupBy('order_code', 'created_at')
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        // GroupBy method from chatGPT
        $myOrder = Order::select(
            'orders.order_code',
            DB::raw('MAX(orders.created_at) as created_at'),
            DB::raw('MAX(orders.status) as status')
        )
            ->where('user_id', Auth::user()->id)
            ->groupBy('orders.order_code')  // Group by order_code
            ->orderBy('created_at', 'desc')  // Order by the most recent created_at
            ->get();
        return view('user.home.orderList', compact('myOrder'));
    }

    public function comment(Request $request)
    {
        Comment::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
            'message' => $request->comment
        ]);

        // ActionLog
        $this->actionLogAdd(Auth::user()->id, $request->productId, 'comment');

        return back();
    }

    public function deleteComment($id){
        Comment::where('id', $id)->delete();
        return back();
    }

    public function rating(Request $request)
    {
        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
        ], [
            'count' => $request->productRating
        ]);

        // ActionLog
        $this->actionLogAdd(Auth::user()->id, $request->productId, 'rating');

        return back();
    }

    public function actionLogAdd($user_id, $post_id, $action)
    {
        ActionLog::create([
            'user_id' => $user_id,
            'post_id' => $post_id,
            'action' => $action
        ]);
    }
}
