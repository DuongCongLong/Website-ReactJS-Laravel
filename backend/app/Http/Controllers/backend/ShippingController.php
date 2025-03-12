<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipping::where('status', '!=', 0);

        // Apply filters if present
        if ($request->filled('shipping_id')) {
            $query->where('shipping_id', 'like', '%' . $request->shipping_id . '%');
        }

        if ($request->filled('shipping_method')) {
            $query->where('shipping_method', 'like', '%' . $request->shipping_method . '%');
        }

        if ($request->filled('cost')) {
            $query->where('cost', 'like', '%' . $request->cost . '%');
        }


        $list = $query->orderBy('created_at', 'DESC')->paginate(4); // Sử dụng phân trang

        return view("backend.shipping.index", compact('list'));
    }
    public function show(string $id)
    {
        $shipping = Shipping::find($id);
        if($shipping ==  null)
        {
            return redirect()->route('admin.shipping.index');
        }

        return view("backend.shipping.show",compact('shipping'));
    }
    public function edit(string $id)
    {
        $shipping = Shipping::find($id);
        if($shipping ==  null)
        {
            return redirect()->route('admin.shipping.index');
        }
        $list=Shipping::where('status','!=',0)
        ->orderBy('created_at','DESC')
        ->get();

       
        return view("backend.shipping.edit",compact('list','shipping'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_id' => 'required|string|max:255',
            'shipping_method' => 'required|string',
            'cost' => 'required|numeric',
            'status' => 'required|integer|in:1,2',
        ]);

        $shipping = new Shipping();
        $shipping->shipping_id = $request->shipping_id;
        $shipping->shipping_method = $request->shipping_method;
        $shipping->cost = $request->cost;
        $shipping->status = $request->status;
        $shipping->created_at = now();
        $shipping->created_by = Auth::id() ?? 1;
        $shipping->save();

        return redirect()->route('admin.shipping.index');
    }
    public function update(Request $request, string $id)
    {
        $shipping = Shipping::find($id);
        if ($shipping == null) {
            return redirect()->route('admin.transaction.index');
        }
        $shipping->shipping_id = $request->shipping_id;
        $shipping->order_id = $request->order_id;
        $shipping->shipping_method = $request->shipping_method;
        $shipping->cost = $request->cost;
        $shipping->updated_at = now();
        $shipping->updated_by = Auth::id() ?? 1;
        $shipping->save();

        return redirect()->route('admin.shipping.index');
    }
    public function create()
    {
        $list=Shipping::where('status','!=',0)
        ->orderBy('created_at','DESC')
        ->get();
        
        return view('backend.shipping.create',compact('list'));
    }
    public function status (string $id)
    {
        $shipping = Shipping::find($id);
        if ($shipping == null) {
            return redirect()->route('admin.shipping.index');
        }
        $shipping->status = ($shipping->status == 1) ? 2: 1;
        $shipping->updated_at = date('Y-m-d H:i:s');
        $shipping->save();
        return redirect()->route('admin.shipping.index');
    }
    public function trash()
    {
        $list = Shipping::where('status', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
    
        return view("backend.shipping.trash", compact('list'));
    }
    public function restore(string $id)
    {
        $shipping = Shipping::find($id);
        if ($shipping == null) {
            return redirect()->route('admin.shipping.index');
        }
    $shipping->status = 2;
    $shipping->updated_at = date('Y-m-d H:i:s');
    $shipping->updated_by = Auth::id() ?? 1;
    $shipping->save();
    return redirect()->route('admin.shipping.index');
    }
    public function destroy(string $id)
    {
        $shipping = Shipping::find($id);
        if ($shipping == null) {
        return redirect()->route('admin.shipping.index');
        }
        $shipping->delete();
        return redirect()->route('admin.shipping.trash');
    }
    public function delete(string $id)
    {
    $shipping = Shipping::find($id);
        if ($shipping == null) {
            return redirect()->route('admin.shipping.index');
        }
    $shipping->status = 0;
    $shipping->updated_at = date('Y-m-d H:i:s');
    $shipping->updated_by = Auth::id() ?? 1;
    $shipping->save();
    return redirect()->route('admin.shipping.index');
    }
}
