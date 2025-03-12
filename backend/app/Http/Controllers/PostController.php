<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Lấy tất cả banner
    public function index()
    {
        $banners = Post::all();
        return response()->json($banners);
    }
    public function show($id)
    {
        $post = Post::find($id);

        // Kiểm tra nếu không tìm thấy bài viết với ID đó
        if (!$post) {
            return response()->json(['message' => 'Bài viết không tồn tại.'], 404);
        }

        return response()->json($post);
    }
}
