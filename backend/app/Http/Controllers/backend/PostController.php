<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Xử lý tìm kiếm
        $query = Post::where('status','!=',0);

        if ($request->filled('title')) {
            $searchTerm = $request->input('title');
            $firstLetter = strtoupper($searchTerm[0]); // Lấy ký tự đầu tiên và chuyển thành chữ hoa
            $query->where('title', 'LIKE', $firstLetter . '%'); // Tìm kiếm các tiêu đề bắt đầu bằng ký tự đầu
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Lọc các bài viết chưa bị xóa
        $list = $query->orderBy('created_at', 'DESC')->paginate(4); // Sử dụng phân trang

        return view("backend.post.index", compact('list'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list = Post::where('status', '!=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        $topics = Topic::all(); // Lấy tất cả các chủ đề

        $htmlparentid = '';
        $htmlsortorder = '';
        foreach ($list as $row) {
            $htmlparentid .= "<option value='" . $row->post_id . "'>" . $row->title . "</option>";
            $htmlsortorder .= "<option value='" . ($row->sort_order + 1) . "'>Sau: " . $row->title . "</option>";
        }

        return view('backend.post.create', compact('list', 'htmlparentid', 'htmlsortorder', 'topics'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Tạo mới bài viết
        $post = new Post();
        $post->title = $request->title;
        $post->detail = $request->detail;
        $post->description = $request->description;
        $post->topic_id = $request->topic_id;
        $post->type = $request->type;

        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::of($request->post_name)->slug('-') . '.' . $exten;
                $request->image->move(public_path('images/posts'), $filename);
                $post->image = $filename;
            }
        }

        $post->status = $request->status;
        $post->updated_at = now();
        $post->updated_by = Auth::id() ?? 1;
        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Bài viết đã được lưu thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $post_id)
    {
        $post = Post::where('post_id', $post_id)->first();
        if ($post ==  null) {
            return redirect()->route('admin.post.index');
        }

        return view("backend.post.show", compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $post_id)
    {
        $post = Post::where('post_id', $post_id)->first();
        if ($post === null) {
            return redirect()->route('admin.post.index');
        }

        $list = Post::where('status', '!=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        $topics = Topic::all(); // Lấy tất cả các chủ đề


        return view("backend.post.edit", compact('list', 'post', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $post_id)
    {
        $post = Post::where('post_id', $post_id)->first();
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        
        $post->title = $request->title;
        $post->detail = $request->detail;
        $post->description = $request->description;
        $post->topic_id = $request->topic_id;
        $post->type = $request->type;
        
        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::of($request->post_name)->slug('-') . '-' . uniqid() . '.' . $exten;
                $request->image->move(public_path('images/posts'), $filename);
                $post->image = $filename;
            }
        }
        
        $post->status = $request->status;
        $post->updated_at = now();
        $post->updated_by = Auth::id() ?? 1;
        $post->save();
        
        return redirect()->route('admin.post.index');
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->status = ($post->status == 1) ? 2 : 1;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->save();
        return redirect()->route('admin.post.index');
    }
    public function delete(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->status = 0;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::id() ?? 1;
        $post->save();
        return redirect()->route('admin.post.index');
    }
    public function trash()
    {
        $list = Post::where('status', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view("backend.post.trash", compact('list'));
    }
    public function restore(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->status = 2;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::id() ?? 1;
        $post->save();
        return redirect()->route('admin.post.index');
    }
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('admin.post.index');
        }
        $post->delete();
        return redirect()->route('admin.post.trash');
    }
}
