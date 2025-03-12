<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    // public function addToCart(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,product_id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);

    //     $user = Auth::user();
    //     if (!$user) {
    //         return response()->json([
    //             'status' => 401,
    //             'message' => 'Login to Add to Cart',
    //         ]);
    //     }

    //     $cart = Cart::where('user_id', $user->id)
    //         ->where('product_id', $request->product_id)
    //         ->first();

    //     if ($cart) {
    //         // Nếu sản phẩm đã có trong giỏ, chỉ cập nhật số lượng
    //         $cart->quantity += $request->quantity;
    //         $cart->save();
    //     } else {
    //         // Nếu chưa có, tạo mới
    //         Cart::create([
    //             'user_id' => $user->id,
    //             'product_id' => $request->product_id,
    //             'quantity' => $request->quantity,
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Product added to cart successfully',
    //     ]);
    // }
    public function addToCart(Request $request) {
        dd($request->all()); // Xem dữ liệu frontend gửi lên
    }
    
    // Lấy giỏ hàng của người dùng
    public function getCartByUserId(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        return response()->json([
            'status' => 200,
            'cart_items' => $cartItems,
        ]);
    }

    // Đồng bộ giỏ hàng từ frontend
    public function syncCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Lưu giỏ hàng vào cơ sở dữ liệu
        foreach ($request->items as $item) {
            Cart::updateOrInsert(
                ['user_id' => $request->user_id, 'product_id' => $item['product_id']],
                ['quantity' => $item['quantity'], 'updated_at' => now()]
            );
        }

        return response()->json([
            'status' => 200,
            'message' => 'Cart synchronized successfully',
        ]);
    }

    // Cập nhật giỏ hàng (thay đổi số lượng)
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);
    

        $cart = Cart::where('product_id', $request->product_id)->first(); 

        if (!$cart) {
            return response()->json([
                'status' => 404,
                'message' => 'Cart item not found',
            ]);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json([
            'status' => 200,
            'message' => 'Cart item updated successfully',
        ]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeCartItem(Request $request)
    {
        $id = $request->input('product_id'); // Lấy product_id từ body request
        $cart = Cart::find($id); // Tìm giỏ hàng dựa trên product_id
    
        if (!$cart) {
            return response()->json([
                'status' => 404,
                'message' => 'Cart item not found',
            ]);
        }
    
        $cart->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Cart item removed successfully',
        ]);
    }
    
}
