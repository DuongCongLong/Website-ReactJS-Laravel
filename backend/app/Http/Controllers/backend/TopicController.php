<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreTopicRequest;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Xử lý tìm kiếm
        $query = Topic::where('status','!=',0);

        if ($request->filled('name')) {
            $searchTerm = $request->input('name');
            $firstLetter = strtoupper($searchTerm[0]); // Lấy ký tự đầu tiên và chuyển thành chữ hoa
            $query->where('name', 'LIKE', $firstLetter . '%'); // Tìm kiếm các tiêu đề bắt đầu bằng ký tự đầu
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Lọc các chủ đề chưa bị xóa
        $list = $query->orderBy('created_at', 'DESC')->paginate(4); // Sử dụng phân trang

        return view("backend.topic.index", compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.topic.create");
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request)
{
    // Tạo chủ đề mới
    $topic = new Topic();
    $topic->name = $request->input('name');
    $topic->description = $request->input('description');
    $topic->status = $request->input('status');
    $topic->user_id = $request->input('user_id');

    // Lưu chủ đề
    $topic->save();

    return redirect()->route('admin.topic.index')->with('success', 'Chủ đề đã được tạo thành công.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $topic_id)
    {
        $topic = Topic::where('topic_id', $topic_id)->first();
        if($topic ==  null)
        {
            return redirect()->route('admin.topic.index');
        }

        return view("backend.topic.show",compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $topic = Topic::find($id);
        if($topic ==  null)
        {
            return redirect()->route('admin.topic.index');
        }
        $list=Topic::where('status','!=',0)
        ->orderBy('created_at','DESC')
        ->get();

       
        return view("backend.topic.edit",compact('list','topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $topic_id)
{
    // Tìm chủ đề theo ID
    $topic = Topic::find($topic_id);
    if ($topic === null) {
        return redirect()->route('admin.topic.index');
    }

    // Cập nhật thông tin chủ đề
    $topic->name = $request->input('name');
    $topic->description = $request->input('description');
    $topic->status = $request->input('status');

    // Lưu chủ đề
    $topic->save();

    return redirect()->route('admin.topic.index')->with('success', 'Chủ đề đã được cập nhật thành công.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function status (string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
        $topic->status = ($topic->status == 1) ? 2: 1;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->save();
        return redirect()->route('admin.topic.index');
    }
    public function delete(string $id)
    {
    $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
    $topic->status = 0;
    $topic->updated_at = date('Y-m-d H:i:s');
    $topic->updated_by = Auth::id() ?? 1;
    $topic->save();
    return redirect()->route('admin.topic.index');
    }
    public function trash()
    {
        $list=Topic::where('status','=',0)
        ->orderBy('created_at','DESC')
        ->get();
        return view("backend.topic.trash",compact('list'));
    }
    public function restore(string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('admin.topic.index');
        }
    $topic->status = 2;
    $topic->updated_at = date('Y-m-d H:i:s');
    $topic->updated_by = Auth::id() ?? 1;
    $topic->save();
    return redirect()->route('admin.topic.index');
    }
    public function destroy(string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
        return redirect()->route('admin.topic.index');
        }
        $topic->delete();
        return redirect()->route('admin.topic.trash');
    }
}
