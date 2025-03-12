<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        try {
            // Validate dữ liệu yêu cầu
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'cart_items' => 'required|array',
                'totalorder' => 'required|numeric',
                'payment_method_id' => 'required|exists:transactions,transaction_id',
                'shipping_method_id' => 'required|exists:shippings,shipping_id',
                'address' => 'required|string',
            ]);
            

            // Kiểm tra user có tồn tại hay không
            $user = User::find($validated['user_id']);
            if (!$user) {
                Log::error('User not found', ['user_id' => $validated['user_id']]);
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            // Tạo đơn hàng mới
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'totalorder' => $validated['totalorder'],
                'payment_method_id' => $validated['payment_method_id'],
                'shipping_method_id' => $validated['shipping_method_id'],
                'address' =>  $validated['address'],
                'status' => 3,
                'username' => $user->name,
                'email' => $user->email,
                'created_by' => $validated['user_id'],
                'updated_by' => $validated['user_id'],
            ]);
            
            $user->cart()->delete(); 
            // Xử lý xóa giỏ hàng sau khi thanh toán (nếu có)
            // Xử lý việc giỏ hàng sau khi tạo đơn hàng có thể được làm như sau (nếu có mối quan hệ với giỏ hàng)
            // User::find($validated['user_id'])->cart()->delete(); 

            // Trả kết quả thành công
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'totalorder' => $order->totalorder,
                    'address' => $order->address,
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                    'shipping_method_id' => $validated['shipping_method_id'],
                    'username' => $user->name,
                    'email' => $user->email,
                    'created_by' => $validated['user_id'],
                    'updated_by' => $validated['user_id'],
                ]
            ], 201);
        } catch (\Exception $e) {
            // Log lỗi nếu có lỗi xảy ra trong quá trình xử lý
            Log::error('Error during order checkout', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred, please try again.',
                'error_details' => $e->getMessage(), // Trả lại thông tin lỗi chi tiết
            ], 500);
        }
    }
}
