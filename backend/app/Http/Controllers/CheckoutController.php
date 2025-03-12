<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $paymentMethod = $request->payment_method;
        if($paymentMethod == 'cod'){
            $order = Order::create([
                "user_id" => $request->userId,
                "order_date" => now(),
                "totalorder" => $request->amount,
                "address" => $request->address,
                "status" => 0

               
            ]);

            $cart = Cart::where('user_id', $request->userId)->get();

            foreach ($cart as $item) {
                $product = Product::find($item->product_id);

                OrderDetail::create([
                    "order_id" => $order->order_id,
                    "product_id" => $item->product_id,
                    "quantity" => $item->quantity,
                    "price" => $item->quantity * $product->price
                ]);

                $item->delete();
            }
            
            return response()->json(['message' => 'Đã đặt đơn hàng thành công'], 200);
        }else{
            $vnp_TmnCode = "48GKZ1C7";
            $vnp_HashSecret = "V2DEFDRLX52OMA8F7Y79HT9NFZNBNU0L";
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://localhost:3000/vnpay-return";
            $vnp_Amount = $request->amount;
            $vnp_Locale = "vn";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $order = Order::create([
                "user_id" => $request->userId,
                "order_date" => now(),
                "totalorder" => $vnp_Amount,
                "status" => 0
              
            ]);

            $vnp_TxnRef = $order->order_id;
    
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount* 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toán đơn hàng",
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            return response()->json(['url' => $vnp_Url]);
        }
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_TxnRef = $request->vnp_TxnRef;
        $vnp_ResponseCode = $request->vnp_ResponseCode;
        
        $order = Order::where('order_id', $vnp_TxnRef)->first();

        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
        }    

        if ($vnp_ResponseCode == "00") {
            $order->status = 1;
            $order->save();
    
            $cart = Cart::where('user_id', $order->user_id)->get();
    
            foreach ($cart as $item) {
                $product = Product::find($item->product_id);
    
                OrderDetail::create([
                    "order_id" => $order->order_id,
                    "product_id" => $item->product_id,
                    "quantity" => $item->quantity,
                    "amount" => $item->quantity * $product->price
                ]);
    
                $item->delete();
            }
    
            return response()->json(['message' => 'Thanh toán thành công'], 200);
        } else {
            return response()->json(['message' => 'Thanh toán thất bại'], 400);
        }
    }
}