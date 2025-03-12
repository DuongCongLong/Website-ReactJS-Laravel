<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Topic;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\StoreMenuRequest;

class MenuController extends Controller
{
    /**
     * Hiển thị danh sách các tài nguyên.
     */
    public function index()
    {
        $list = Menu::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->select("id", "name", "link", "position",'status')
            ->paginate(5); // Phân trang với 5 bản ghi mỗi trang
        
        $list_category = Category::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->select("id", "name")
            ->paginate(5); // Phân trang với 5 bản ghi mỗi trang
        
        $list_brand = Brand::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->select("id", "name")
            ->paginate(5); // Phân trang với 5 bản ghi mỗi trang
        
        $list_topic = Topic::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->select("topic_id", "name")
            ->paginate(5); // Phân trang với 5 bản ghi mỗi trang
        
        $list_page = Post::where([['status', '!=', 0], ['type', '=', 'page']])
            ->orderBy('created_at', 'desc')
            ->select("post_id", "title")
            ->paginate(5); // Phân trang với 5 bản ghi mỗi trang
    
        return view("backend.menu.index", compact('list', 'list_category', 'list_brand', 'list_topic', 'list_page'));
    }
    

    public function trash()
    {
        $list = Menu::where('status', '=', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.menu.trash', compact('list'));
    }

    /**
     * Hiển thị form tạo mới tài nguyên.
     */
    public function create()
{
    $list_category = Category::where('status', '!=', 0)
        ->orderBy('created_at', 'desc')
        ->select("id", "name")
        ->get();
    $list_brand = Brand::where('status', '!=', 0)
        ->orderBy('created_at', 'desc')
        ->select("id", "name")
        ->get();
    $list_topic = Topic::where('status', '!=', 0)
        ->orderBy('created_at', 'desc')
        ->select("topic_id", "name")
        ->get();
    $list_page = Post::where([['status', '!=', 0], ['type', '=', 'page']])
        ->orderBy('created_at', 'desc')
        ->select("post_id", "title")
        ->get();

    return view('backend.menu.create', compact('list_category', 'list_brand', 'list_topic', 'list_page'));
}


    /**
     * Lưu một tài nguyên mới được tạo vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $position = ($request->position === 'mainmenu') ? 1 : 2;
    
        if(isset($request->createBrand))
        {
            $listid = $request->brandid;
            if($listid){
                foreach($listid as $id)
                {
                    $brand = Brand::find($id);
                    if($brand != null){
                        $menu = new Menu();
                        $menu->name = $brand->name;
                        $menu->link = 'thuong-hieu/' . $brand->slug;
                        $menu->sort_order = 0;
                        $menu->parent_id = 0;
                        $menu->type = 'brand';
                        $menu->position = $position; // Sử dụng vị trí từ request
                        $menu->table_id = $id;
                        $menu->created_at = now();
                        $menu->created_by = Auth::id() ?? 1;
                        $menu->status = 1;
                        $menu->save();
                    }
                }
                return redirect()->route('admin.menu.index');
            } else {
                return back()->with('error', 'Không có danh mục nào được chọn.');
            }
        }
    
        if(isset($request->createCategory))
        {
            $listid = $request->categoryid;
            if($listid){
                foreach($listid as $id)
                {
                    $category = Category::find($id);
                    if($category != null){
                        $menu = new Menu();
                        $menu->name = $category->name;
                        $menu->link = 'danh-muc/' . $category->slug;
                        $menu->sort_order = 0;
                        $menu->parent_id = 0;
                        $menu->type = 'category';
                        $menu->position = $position; // Sử dụng vị trí từ request
                        $menu->table_id = $id;
                        $menu->created_at = now();
                        $menu->created_by = Auth::id() ?? 1;
                        $menu->status = 1;
                        $menu->save();
                    }
                }
                return redirect()->route('admin.menu.index');
            } else {
                return back()->with('error', 'Không có danh mục nào được chọn.');
            }
        }
    
        if(isset($request->createTopic))
        {
            $listid = $request->topicid;
            if($listid){
                foreach($listid as $id)
                {
                    $topic = Topic::find($id);
                    if($topic != null){
                        $menu = new Menu();
                        $menu->name = $topic->name;
                        $menu->link = 'chu-de/' . $topic->slug;
                        $menu->sort_order = 0;
                        $menu->parent_id = 0;
                        $menu->type = 'topic';
                        $menu->position = $position; // Sử dụng vị trí từ request
                        $menu->table_id = $id;
                        $menu->created_at = now();
                        $menu->created_by = Auth::id() ?? 1;
                        $menu->status = 1;
                        $menu->save();
                    }
                }
                return redirect()->route('admin.menu.index');
            } else {
                return back()->with('error', 'Không có chủ đề nào được chọn.');
            }
        }
    
        if(isset($request->createPage))
        {
            $listid = $request->pageid;
            if($listid){
                foreach($listid as $id)
                {
                    $page = Post::where([['post_id','=',$id],['type','=','page']])->first();
                    if($page != null){
                        $menu = new Menu();
                        $menu->name = $page->title;
                        $menu->link = 'trang-don/' . $page->slug;
                        $menu->sort_order = 0;
                        $menu->parent_id = 0;
                        $menu->type = 'page';
                        $menu->position = $position; // Sử dụng vị trí từ request
                        $menu->table_id = $id;
                        $menu->created_at = now();
                        $menu->created_by = Auth::id() ?? 1;
                        $menu->status = 1;
                        $menu->save();
                    }
                }
                return redirect()->route('admin.menu.index');
            } else {
                return back()->with('error', 'Không có trang đơn nào được chọn.');
            }
        }
    
        if(isset($request->createCustom))
        {
            if ($request->name && $request->link) {
                $menu = new Menu();
                $menu->name = $request->name;
                $menu->link = $request->link;
                $menu->sort_order = 0;
                $menu->parent_id = 0;
                $menu->type = 'custom';
                $menu->position = $position; // Sử dụng vị trí từ request
                $menu->created_at = now();
                $menu->created_by = Auth::id() ?? 1;
                $menu->status = 1;
                $menu->save();
                return redirect()->route('admin.menu.index');
            } else {
                return back()->with('error', 'Vui lòng cung cấp tên và liên kết.');
            }
        }
    }
    

    /**
     * Hiển thị một tài nguyên cụ thể.
     */
    public function show($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index')->with('error', 'Không tìm thấy menu.');
        }
        return view('backend.menu.show', ['menu' => $menu]);
    }

    /**
     * Hiển thị form chỉnh sửa tài nguyên cụ thể.
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index');
        }

        $list_category = Category::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->select('id', 'name')
            ->get();
        $list_brand = Brand::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->select('id', 'name')
            ->get();
        $list_topic = Topic::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->select('topic_id', 'name')
            ->get();
        $list_page = Post::where([['status', '!=', 0], ['type', '=', 'page']])
            ->orderBy('created_at', 'desc')
            ->select('post_id', 'title')
            ->get();

        $list = Menu::where('status', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $htmlparentid = '';
        $htmlsortorder = '';
        $htmltype = '';
        $htmlposition = '';

        foreach ($list as $item) {
            $htmlparentid .= "<option value='{$item->id}'" . ($menu->parent_id == $item->id ? ' selected' : '') . ">{$item->name}</option>";
            $htmlsortorder .= "<option value='" . ($item->sort_order + 1) . "'" . (($menu->sort_order - 1) == $item->sort_order ? ' selected' : '') . ">Sau: {$item->name}</option>";
        }

        $types = ['category', 'brand', 'topic', 'page', 'custom'];
        foreach ($types as $value) {
            $htmltype .= "<option value='{$value}'" . ($menu->type == $value ? ' selected' : '') . ">{$value}</option>";
        }

        $positions = [
            'mainmenu' => 'Main Menu',
            'footermenu' => 'Footer Menu',
        ];
        foreach ($positions as $key => $value) {
            $htmlposition .= "<option value='{$key}'" . ($menu->position == $key ? ' selected' : '') . ">{$value}</option>";
        }

        return view('backend.menu.edit', compact('menu', 'htmlparentid', 'htmlsortorder', 'htmltype', 'htmlposition', 'list_category', 'list_brand', 'list_topic', 'list_page'));
    }

    /**
     * Cập nhật tài nguyên cụ thể trong cơ sở dữ liệu.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index')->with('error', 'Không tìm thấy menu.');
        }

        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->parent_id = $request->parent_id;
        $menu->sort_order = $request->sort_order;
        $menu->type = $request->type;
        $menu->position = $request->position;
        $menu->status = $request->status;
        $menu->updated_at = now();
        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Đã cập nhật menu thành công.');
    }

    /**
     * Xóa tài nguyên cụ thể khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index')->with('error', 'Không tìm thấy menu.');
        }
        $menu->delete();

        return redirect()->route('admin.menu.trash')->with('success', 'Đã xóa menu thành công.');
    }

    public function restore($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index')->with('error', 'Không tìm thấy menu.');
        }
        $menu->status = 2;
        $menu->updated_at = now();
        $menu->updated_by = Auth::id() ?? 1;
        $menu->save();

        return redirect()->route('admin.menu.trash')->with('success', 'Đã khôi phục menu thành công.');
    }

    public function status($id)
    {
        $menu = Menu::findOrFail($id);

        if (!$menu) {
            return redirect()->route('admin.menu.index')->with('error', 'Không tìm thấy menu.');
        }
        $menu->status = $menu->status == 1 ? 2 : 1;
        $menu->updated_at = now();
        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Đã cập nhật trạng thái menu thành công.');
    }

    public function delete($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('admin.menu.index')->with('error', 'Không tìm thấy menu.');
        }
        $menu->status = 0;
        $menu->updated_at = now();
        $menu->updated_by = Auth::id() ?? 1;
        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Đã chuyển menu vào thùng rác.');
    }
}
