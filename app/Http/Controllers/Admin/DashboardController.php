<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Service;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'total_users'     => User::where('role', 'user')->count(),
            'total_services'  => Service::count(),
            'total_revenue'   => Payment::where('status', 'paid')->sum('amount'),
            'pending_payments'=> Payment::where('status', 'pending')->count(),
        ];

        $recent_orders = Order::with('user')
            ->latest()->take(8)->get();

        $recent_payments = Payment::with('order.user')
            ->where('status', 'pending')
            ->latest()->take(6)->get();

        return view('admin.dashboard.index', compact('stats', 'recent_orders', 'recent_payments'));
    }
}
