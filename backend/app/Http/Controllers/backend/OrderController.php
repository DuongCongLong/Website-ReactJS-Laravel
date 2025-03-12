<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query builder cho bảng orders
        $query = DB::table('orders')
        ->join('shippings', 'orders.shipping_method_id', '=', 'shippings.shipping_id')
        ->join('shipping_statuses', 'orders.status', '=', 'shipping_statuses.id')
        ->join('transactions', 'orders.payment_method_id', '=', 'transactions.transaction_id')
        ->select(
            'orders.*',
            'shippings.shipping_method',
            'shipping_statuses.status as shipping_status',
            'transactions.payment_method'
        )
            ->where('orders.status', '!=', 0);

        // Áp dụng bộ lọc theo ID đơn hàng
        if ($request->filled('order_id')) {
            $query->where('orders.order_id', $request->input('order_id'));
        }

        // Áp dụng bộ lọc theo trạng thái giao hàng
        if ($request->filled('shipping_status')) {
            $query->where('shipping_statuses.status', 'like', '%' . $request->input('shipping_status') . '%');
        }

        // Áp dụng bộ lọc theo phương thức thanh toán
        if ($request->filled('payment_method')) {
            $query->where('transactions.payment_method', 'like', '%' . $request->input('payment_method') . '%');
        }

        // Áp dụng bộ lọc theo số lượng
        if ($request->filled('quantity')) {
            $query->where('orders.totalorder', $request->input('quantity'));
        }

        // Áp dụng bộ lọc theo địa chỉ
        if ($request->filled('address')) {
            $query->where('orders.address', 'like', '%' . $request->input('address') . '%');
        }

        // Áp dụng bộ lọc theo phương pháp vận chuyển
        if ($request->filled('shipping_method')) {
            $query->where('shippings.shipping_method', 'like', '%' . $request->input('shipping_method') . '%');
        }

        // Áp dụng bộ lọc theo ngày đặt hàng
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->input('date_range'));
            if (count($dates) === 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereBetween('orders.order_date', [$startDate, $endDate]);
            }
        }
        // Lấy dữ liệu đơn hàng
        $orders = $query->orderBy('orders.created_at', 'DESC')->get();
        // Tính số lượng đơn hàng theo từng trạng thái
        $statusCounts = DB::table('orders')
        ->join('shipping_statuses', 'orders.status', '=', 'shipping_statuses.id')
        ->select('shipping_statuses.status', DB::raw('COUNT(orders.order_id) as count'))
        ->groupBy('shipping_statuses.status')
        ->pluck('count', 'status')
        ->toArray();

        $list = $query->orderBy('created_at', 'DESC')->paginate(4); // Sử dụng phân trang

        return view('backend.order.index', compact('list','orders', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

     public function show(string $id)
     {
         $order = Order::with('orderDetails')
             ->join('shippings', 'orders.shipping_method_id', '=', 'shippings.shipping_id')
             ->join('shipping_statuses', 'orders.status', '=', 'shipping_statuses.id')
             ->join('transactions', 'orders.payment_method_id', '=', 'transactions.transaction_id')
             ->select(
                 'orders.*',
                 'shippings.shipping_method',
                 'shipping_statuses.status as shipping_status',
                 'transactions.payment_method'
             )
             ->where('orders.order_id', $id)
             ->first();
     
         if ($order == null) {
             return redirect()->route('admin.order.index');
         }
     
         return view("backend.order.show", compact('order'));
     }
     
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('admin.order.index');
        }
        $order->status = ($order->status == 1) ? 2 : 1;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();
        return redirect()->route('admin.order.index');
    }
    public function delete(string $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('admin.order.index');
        }
        $order->status = 0;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->updated_by = Auth::id() ?? 1;
        $order->save();
        return redirect()->route('admin.order.index');
    }
    public function trash()
    {
        $list = Order::where('status', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view("backend.order.trash", compact('list'));
    }
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('admin.order.index');
        }
        $order->delete();
        return redirect()->route('admin.order.trash');
    }
    public function restore(string $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('admin.order.index');
        }
        $order->status = 2;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->updated_by = Auth::id() ?? 1;
        $order->save();
        return redirect()->route('admin.order.index');
    }
}
