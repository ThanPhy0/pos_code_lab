<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //direct admin page
    public function Admin(){
        $total_amt = number_format(PaymentHistory::sum('total_amt'));

        $order = number_format(Order::where('status', 1)->count('status'));

        $user_count = number_format(User::where('role', 'user')->count('role'));

        $pending_request = number_format(Order::where('status', 0)->count('status'));

        return view('admin.home.index', compact('total_amt', 'order', 'user_count', 'pending_request'));
    }
}
