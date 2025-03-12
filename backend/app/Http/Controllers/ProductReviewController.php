<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    /**
     * Lưu đánh giá sản phẩm.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu từ frontend
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id', // Validate product_id
            'rating' => 'required|integer|min:1|max:5',     // Validate rating (1-5)
            'review_text' => 'nullable|string|max:1000',   // Validate nội dung đánh giá
        ]);

        // Lấy ID của người dùng hiện tại
        $user_id = Auth::id();

        if (!$user_id) {
            return response()->json(['error' => 'Người dùng chưa đăng nhập.'], 401);
        }

        // Lưu dữ liệu vào database
        try {
            $review = new ProductReview();
            $review->product_id = $validated['product_id'];
            $review->user_id = $user_id;
            $review->rating = $validated['rating'];
            $review->review_text = $validated['review_text'] ?? null;
            $review->image = null; // Hình ảnh để null

            $review->created_by = $user_id;
            $review->status = 'pending'; // Đánh giá mặc định là "chờ duyệt"
            $review->save();

            return response()->json(['message' => 'Đánh giá đã được gửi thành công.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể gửi đánh giá.'], 500);
        }
    }
    public function show($id)
    {
        $reviews = ProductReview::where('product_id', $id)->get();
        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'Reviews not found'], 404);
        }
        return response()->json($reviews, 200);
    }
    
}
