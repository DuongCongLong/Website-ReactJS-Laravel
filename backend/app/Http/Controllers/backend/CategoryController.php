<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories()
    {
        $category = Category::all();
        return response()->json($category);
    }
    public function getProductCount($id)
    {
        // Lấy danh mục theo id
        $category = Category::find($id);

        // Kiểm tra nếu danh mục tồn tại
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Lấy số lượng sản phẩm thuộc danh mục này
        $productCount = $category->products()->count(); // Giả sử bạn đã định nghĩa mối quan hệ products trong model Category

        // Trả về số lượng sản phẩm
        return response()->json(['productCount' => $productCount]);
    }
    public function index(Request $request)
    {
        $query = Category::query();
        
        // Lọc theo tên nếu có
        if ($request->filled('name')) {
            $query->where('name', 'like', $request->input('name') . '%');
        }
        
        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        // Lọc các danh mục có tên bắt đầu bằng chữ cái cụ thể nếu có
        if ($request->filled('starts_with')) {
            $query->where('name', 'like', $request->input('starts_with') . '%');
        }
        
        // Phân trang kết quả
        $categories = $query->paginate(10); // Thay đổi số lượng bản ghi mỗi trang tùy theo nhu cầu
        
        $htmlparentid = '';
        $htmlsortorder = '';
        
        foreach ($categories as $item) {
            $htmlparentid .= "<option value='".$item->id."'>".$item->name."</option>";
            $htmlsortorder .= "<option value='".($item->sort_order + 1)."'>Sau: ".$item->name."</option>";
        }
        
        return view("backend.category.index", compact('categories', 'htmlparentid', 'htmlsortorder'));
    }
    
    
    
    public function show(string $id)
    {
                
        $category = Category::find($id);
        if($category ==  null)
        {
            return redirect()->route('admin.category.index');
        }

        return view("backend.category.show",compact('category'));
    }

    public function store(StoreCategoryRequest $request)
    {

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = Str::of($request->name)->slug('-');
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        if ($request->image){
            $exten = $request->file("image")->extension();
            if(in_array($exten,["png","jpg","gif","webp"]))
            {
                $filename = $category->slug . "." . $exten;
                $request->image->move(public_path("images/categorys"),$filename);
                $category->image = $filename;
            }
        }
        $category->status = $request->status;
        $category->created_at = date('Y-m-d H:i:s');
        $category->created_by = Auth::id() ?? 1;
        $category->save();
        return redirect()->route('admin.category.index');
    }

    public function edit(string $id)
    {
        $category = Category::find($id);
        if($category ==  null)
        {
            return redirect()->route('admin.category.index');
        }
        $list=Category::where('status','!=',0)
        ->select("id","name","sort_order")
        ->orderBy('created_at','DESC')
        ->get();

        $htmlparentid='';
        $htmlsortorder='';
        foreach($list as $row)
        {
            if($category->parent_id == $row->id)
            {
                $htmlparentid.="<option selected value='".$row->id."'>".$row->name."</option>";
            }
            else
            {
                $htmlparentid.="<option value='".$row->id."'>".$row->name."</option>";
            }
            if($category->sort_order-1 == $row->sort_order)
            {
                $htmlsortorder.="<option selected value='".($row->sort_order + 1)."'>Sau: ".$row->name."</option>";
            }
            else
            {
                $htmlsortorder.="<option value='".($row->sort_order + 1)."'>Sau: ".$row->name."</option>";
            }
        }
        return view("backend.category.edit",compact('list','htmlparentid','htmlsortorder','category'));
    }

    public function trash()
    {
        $list=Category::where('status','=',0)
        ->select("id","name","image","slug","status" ,"sort_order")
        ->orderBy('created_at','DESC')
        ->get();
        return view("backend.category.trash",compact('list'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy (string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
        return redirect()->route('admin.category.index');
        }
        $category->delete();
        return redirect()->route('admin.category.trash');
    }

    public function status (string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index');
        }
        $category->status = ($category->status == 1) ? 2: 1;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->save();
        return redirect()->route('admin.category.index');
    }

    public function delete(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index')->with('error', 'Danh mục không tồn tại.');
        }
    
        // Kiểm tra nếu có sản phẩm liên quan đến category_id này
        $productsCount = Product::where('category_id', $id)->count();
    
        if ($productsCount > 0) {
            return redirect()->route('admin.category.index')->with('error', 'Danh mục này có sản phẩm liên quan, không thể xóa.');
        }
    
        // Tiến hành xóa nếu không có sản phẩm liên quan
        $category->status = 0;
        $category->updated_at = now();
        $category->updated_by = Auth::id() ?? 1;
        $category->save();
    
        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được xóa.');
    }
    


    public function restore(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('admin.category.index');
        }
    $category->status = 2;
    $category->updated_at = date('Y-m-d H:i:s');
    $category->updated_by = Auth::id() ?? 1;
    $category->save();
    return redirect()->route('admin.category.index');
    }
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if($category ==  null)
        {
            return redirect()->route('admin.category.index');
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = Str::of($request->name)->slug('-');
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        if ($request->image){
            $exten = $request->file("image")->extension();
            if(in_array($exten,["png","jpg","gif","webp"]))
            {
                $filename = $category->slug . "." . $exten;
                $request->image->move(public_path("images/categorys"),$filename);
                $category->image = $filename;
            }
        }
        $category->status = $request->status;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = Auth::id() ?? 1;
        $category->save();
        return redirect()->route('admin.category.index');
    }

}
