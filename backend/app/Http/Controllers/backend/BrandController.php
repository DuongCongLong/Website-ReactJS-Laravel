<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

class BrandController extends Controller
{
    public function brands()
    {
        $brand = Brand::all();
        return response()->json($brand);
    }
    public function index(Request $request)
    {
        $query = Brand::query();
        
        // Lọc theo tên nếu có
        if ($request->filled('name')) {
            $query->where('name', 'like', $request->input('name') . '%');
        }
        
        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        // Lấy danh sách thương hiệu
        $list = $query->paginate(10); // Thay đổi số lượng bản ghi per page nếu cần
        
        return view('backend.brand.index', compact('list'));
    }
    
    public function store(StoreBrandRequest $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slug = Str::of($request->name)->slug('-');
        $brand->sort_order = $request->sort_order;
        if ($request->image){
            $exten = $request->file("image")->extension();
            if(in_array($exten,["png","jpg","gif","webp"]))
            {
                $filename = $brand->slug . "." . $exten;
                $request->image->move(public_path("images/brands"),$filename);
                $brand->image = $filename;
            }
        }
        $brand->status = $request->status;
        $brand->created_at = date('Y-m-d H:i:s');
        $brand->created_by = Auth::id() ?? 1;
        $brand->save();
        return redirect()->route('admin.brand.index');
    }
    public function show(string $id)
    {
        $brand = Brand::find($id);
        if($brand ==  null)
        {
            return redirect()->route('admin.brand.index');
        }

        return view("backend.brand.show",compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        if($brand ==  null)
        {
            return redirect()->route('admin.brand.index');
        }
        $list=Brand::where('status','!=',0)
        ->select("id","image","sort_order","name","slug","status")
        ->orderBy('created_at','DESC')
        ->get();

        return view("backend.brand.edit",compact('list','brand'));
    }
    public function create()
    {
        $list=Brand::where('status','!=',0)
        ->orderBy('created_at','DESC')
        ->get();
        return view("backend.brand.create",compact('list'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }

        // Cập nhật dữ liệu của brand
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slug = Str::of($request->name)->slug('-');
        $brand->sort_order = $request->sort_order;
        
        if ($request->hasFile('image')) {
            $exten = $request->file("image")->extension();
            if (in_array($exten, ["png", "jpg", "gif", "webp"])) {
                $filename = $brand->slug . "." . $exten;
                $request->image->move(public_path("images/brands"), $filename);
                $brand->image = $filename;
            }
        }

        $brand->status = $request->status;
        $brand->updated_at = now();
        $brand->updated_by = Auth::id() ?? 1;
        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Thương hiệu đã được cập nhật.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index')->with('error', 'Thương hiệu không tồn tại.');
        }

        // Kiểm tra nếu có sản phẩm liên quan đến brand_id này
        $productsCount = Product::where('brand_id', $id)->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.brand.index')->with('error', 'Thương hiệu này có sản phẩm liên quan, không thể xóa.');
        }

        // Tiến hành xóa nếu không có sản phẩm liên quan
        $brand->status = 0;
        $brand->updated_at = now();
        $brand->updated_by = Auth::id() ?? 1;
        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Thương hiệu đã được xóa.');
    }

    public function trash()
    {
        $list=Brand::where('status','=',0)
        ->select("id","image","sort_order","name","slug","status")
        ->orderBy('created_at','DESC')
        ->get();
        return view("backend.brand.trash",compact('list'));
    }
    public function destroy (string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
        return redirect()->route('admin.brand.index');
        }
        $brand->delete();
        return redirect()->route('admin.brand.trash');
    }
    public function restore(string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }
    $brand->status = 2;
    $brand->updated_at = date('Y-m-d H:i:s');
    $brand->updated_by = Auth::id() ?? 1;
    $brand->save();
    return redirect()->route('admin.brand.index');
    }
    public function status (string $id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('admin.brand.index');
        }
        $brand->status = ($brand->status == 1) ? 2: 1;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->save();
        return redirect()->route('admin.brand.index');
    }
    public function deletemultiple(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
    
        // Kiểm tra có sản phẩm liên quan đến thương hiệu nào không
        $brandsWithProducts = Brand::whereIn('id', $ids)
            ->whereHas('products') // Đây là quan hệ Eloquent nếu bạn đã định nghĩa mối quan hệ trong model Brand
            ->pluck('id');
    
        if ($brandsWithProducts->isNotEmpty()) {
            return redirect()->route('admin.brand.index')
                ->with('error', 'Không thể xóa các thương hiệu có sản phẩm liên quan.');
        }
    
        // Cập nhật trạng thái của các thương hiệu không có sản phẩm liên quan
        Brand::whereIn('id', $ids)->update([
            'status' => 0, // Cập nhật trạng thái thành 0 để đưa vào thùng rác
            'updated_by' => Auth::id() ?? 1,
        ]);
    
        return redirect()->route('admin.brand.index')
            ->with('success', 'Các thương hiệu đã được xóa.');
    }    
    
}

