<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact; // Import model Contact nếu có
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Lưu thông tin liên hệ.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu từ frontend
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Validate tên
            'email' => 'required|email|max:255', // Validate email
            'msg' => 'required|string|max:1000', // Validate tin nhắn
            'user_id' => 'required|exists:users,id', // Validate user_id
        ]);
        $user_id = $request->input('user_id');

        // Kiểm tra xem user_id có tồn tại không
        if (!$user_id) {
            return response()->json(['error' => 'Không tìm thấy thông tin người dùng.'], 400);
        }

        // Lưu dữ liệu vào database
        try {
            $contact = new Contact();
            $contact->name = $validated['name']; // Lưu tên
            $contact->email = $validated['email']; // Lưu email
            $contact->message = $validated['msg']; // Lưu tin nhắn
            $contact->user_id = $user_id; // Lưu tin nhắn
            $contact->save();

            // Phản hồi thành công
            return response()->json(['message' => 'Liên hệ đã được gửi thành công.'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi khi lưu
            return response()->json(['error' => 'Không thể gửi liên hệ.'], 500);
        }
    }
}