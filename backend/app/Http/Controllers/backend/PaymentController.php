<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $list=Payment::where('status','!=',0)
        ->orderBy('created_at','DESC')
        ->get();
        
        return view("backend.payment.index",compact('list'));
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = new Payment();
        $payment->payment_method = $request->payment_method;
        $payment->amount = $request->amount;
        $payment->status = $request->status;
        $payment->created_at = now();
        $payment->created_by = Auth::id() ?? 1;
        $payment->save();
        return redirect()->route('admin.payment.index')->with('success', 'Phương thức thanh toán đã được thêm.');
    }
    public function show(string $id)
    {
        $payment = Payment::find($id);
        if($payment ==  null)
        {
            return redirect()->route('admin.payment.index');
        }

        return view("backend.payment.show",compact('payment'));
    }
    public function create()
    {
        return view("backend.payment.create");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::find($id);
        if($payment ==  null)
        {
            return redirect()->route('admin.payment.index');
        }
        $list=Payment::where('status','!=',0)
        ->select("id","status")
        ->orderBy('created_at','DESC')
        ->get();

        
        return view("backend.payment.edit",compact('list','payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Tìm thanh toán theo ID
    $payment = Payment::find($id);

    if ($payment == null) {
        return redirect()->route('admin.payment.index');
    }

    // Cập nhật các trường của thanh toán
    $payment->payment_method = $request->payment_method;
    $payment->amount = $request->amount;

    $payment->updated_at = date('Y-m-d H:i:s');
    $payment->updated_by = Auth::id() ?? 1; 

    // Lưu cập nhật
    $payment->save();

    return redirect()->route('admin.payment.index');
}
    
    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $payment = Payment::find($id);
            if ($payment == null) {
                return redirect()->route('admin.payment.index');
            }
        $payment->status = 0;
        $payment->updated_at = date('Y-m-d H:i:s');
        $payment->updated_by = Auth::id() ?? 1;
        $payment->save();
        return redirect()->route('admin.payment.index');
    }
    public function trash()
    {
        $list= Payment::orderBy('created_at','DESC')
        ->get();
        return view("backend.payment.trash",compact('list'));
    }
    public function destroy (string $id)
    {
        $payment = Payment::find($id);
        if ($payment == null) {
        return redirect()->route('admin.payment.index');
        }
        $payment->delete();
        return redirect()->route('admin.payment.trash');
    }
    public function restore(string $id)
    {
        $payment = Payment::find($id);
        if ($payment == null) {
            return redirect()->route('admin.payment.index');
        }
    $payment->status = 2;
    $payment->updated_at = date('Y-m-d H:i:s');
    $payment->updated_by = Auth::id() ?? 1;
    $payment->save();
    return redirect()->route('admin.payment.index');
    }
    public function status (string $id)
    {
        $payment = Payment::find($id);
        if ($payment == null) {
            return redirect()->route('admin.payment.index');
        }
        $payment->status = ($payment->status == 1) ? 2: 1;
        $payment->updated_at = date('Y-m-d H:i:s');
        $payment->save();
        return redirect()->route('admin.payment.index');
    }
}
