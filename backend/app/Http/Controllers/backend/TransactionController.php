<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('status', '!=', 0);

        // Apply filters if provided
        if ($request->has('order_id') && !empty($request->order_id)) {
            $query->where('order_id', 'like', '%' . $request->order_id . '%');
        }
        if ($request->has('amount') && !empty($request->amount)) {
            $query->where('amount', $request->amount);
        }
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        $list = $query->orderBy('created_at', 'DESC')->get()->unique('order_id');

        $list = $query->orderBy('created_at', 'DESC')->paginate(4); // Sử dụng phân trang
        return view("backend.transaction.index", compact('list'));
    }
    public function show(string $transaction_id)
    {
        $transaction = Transaction::where('transaction_id', $transaction_id)->first();
        if($transaction ==  null)
        {
            return redirect()->route('admin.transaction.index');
        }

        return view("backend.transaction.show",compact('transaction'));
    }
    public function delete(string $id)
    {
        $transaction = Transaction::find($id);
            if ($transaction == null) {
                return redirect()->route('admin.transaction.index');
            }
        $transaction->status = 0;
        $transaction->updated_at = date('Y-m-d H:i:s');
        $transaction->updated_by = Auth::id() ?? 1;
        $transaction->save();
        return redirect()->route('admin.transaction.index');
    }

    public function update(Request $request, string $transaction_id)
    {
        $transaction = Transaction::where('transaction_id', $transaction_id)->first();
        if ($transaction == null) {
            return redirect()->route('admin.transaction.index');
        }

        // Cập nhật các trường
        $transaction->order_id = $request->order_id;
        $transaction->amount = $request->amount;
        $transaction->payment_method = $request->payment_method;

        // Kiểm tra và cập nhật hình ảnh nếu có
        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::of($request->name)->slug('-') . '.' . $exten;
                $request->image->move(public_path('images/transactions'), $filename);
                $transaction->image = $filename;
            }
        }

        $transaction->status = $request->status ?? $transaction->status;
        $transaction->updated_at = now();
        $transaction->updated_by = Auth::id() ?? 1;
        $transaction->save();

        return redirect()->route('admin.transaction.index');
    }


    public function trash()
    {
        $list = Transaction::where('status', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
    
        return view("backend.transaction.trash", compact('list'));
    }
    public function restore(string $id)
    {
        $transaction = Transaction::find($id);
        if ($transaction == null) {
            return redirect()->route('admin.transaction.index');
        }
    $transaction->status = 2;
    $transaction->updated_at = date('Y-m-d H:i:s');
    $transaction->updated_by = Auth::id() ?? 1;
    $transaction->save();
    return redirect()->route('admin.transaction.index');
    }

    public function status (string $id)
    {
        $transaction = Transaction::find($id);
        if ($transaction == null) {
            return redirect()->route('admin.transaction.index');
        }
        $transaction->status = ($transaction->status == 1) ? 2: 1;
        $transaction->updated_at = date('Y-m-d H:i:s');
        $transaction->save();
        return redirect()->route('admin.transaction.index');
    }
    public function create()
    {
        return view('backend.transaction.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        $transaction = new Transaction();
        $transaction->order_id = $request->order_id;
        $transaction->amount = $request->amount;
        $transaction->payment_method = $request->payment_method;
        $transaction->status = 1;
        $transaction->created_at = now();
        $transaction->updated_by = Auth::id() ?? 1;

        if ($request->hasFile('image')) {
            $exten = $request->file('image')->extension();
            if (in_array($exten, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $filename = Str::of($request->name)->slug('-') . '.' . $exten;
                $request->image->move(public_path('images/transactions'), $filename);
                $transaction->image = $filename;
            }
        }

        $transaction->save();

        return redirect()->route('admin.transaction.index');
    }
    public function edit(string $transaction_id)
    {
        // Lấy giao dịch theo ID
        $transaction = Transaction::where('transaction_id', $transaction_id)->first();

        // Kiểm tra xem giao dịch có tồn tại không
        if ($transaction == null) {
            return redirect()->route('admin.transaction.index');
        }

        // Trả về view chỉnh sửa với giao dịch đã lấy được
        return view('backend.transaction.edit', compact('transaction'));
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        if ($transaction == null) {
        return redirect()->route('admin.transaction.index');
        }
        $transaction->delete();
        return redirect()->route('admin.transaction.trash');
    }

}
