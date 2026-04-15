<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders
     */
    public function index()
    {
        $orders = Order::with(["user", "items"])
            ->latest()
            ->paginate(15);

        return view("admin.orders.index", compact("orders"));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(["user", "items.product"]);

        return view("admin.orders.show", compact("order"));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            "status" =>
                "required|in:pending,processing,shipped,delivered,cancelled",
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return back()->with("info", "Order status is already {$newStatus}.");
        }

        $order->update(["status" => $newStatus]);

        if ($order->user) {
            $statusLabel = ucfirst($newStatus);
            $message = match ($newStatus) {
                'pending' => "Your order {$order->order_number} is now pending.",
                'processing' => "Your order {$order->order_number} is now processing.",
                'shipped' => "Your order {$order->order_number} has been shipped.",
                'delivered' => "Your order {$order->order_number} has been delivered.",
                'cancelled' => "Your order {$order->order_number} has been cancelled.",
                default => "Your order {$order->order_number} status has been updated to {$statusLabel}.",
            };

            $order->user->notify(new UserNotification(
                "Order {$statusLabel}",
                $message,
                route('checkout.success', $order),
            ));
        }

        return back()->with("success", "Order status updated successfully!");
    }

    /**
     * Filter orders by status
     */
    public function filter(Request $request)
    {
        $query = Order::with(["user", "items"]);

        if ($request->filled("status")) {
            $query->where("status", $request->status);
        }

        if ($request->filled("search")) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw("LOWER(order_number) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(first_name) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(last_name) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(email) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(phone) LIKE ?", ["%{$search}%"]);
            });
        }

        $orders = $query->latest()->paginate(15);

        return view("admin.orders.index", compact("orders"));
    }
}
