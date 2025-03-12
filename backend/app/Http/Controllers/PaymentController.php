<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:3000/vnpay-return";
        $vnp_TmnCode = "48GKZ1C7";//Mã website tại VNPAY 
        $vnp_HashSecret = "HZKH75YH7JYDOB62GOLQCK4AOIZ56UKP"; //Chuỗi bí mật
        
        $order = Order::create([
            "user_id" => $request->user_id,
            "order_date" => now(),
            "totalorder" => $request->totalorder,
            "status" => 3,
            "address" => $request->address, // Thêm các trường khác nếu cần
            "shipping_method_id" => $request->shipping_method_id,
            "payment_method_id" => $request->payment_method_id,
            "shipping_status_id" => 1, // Ví dụ, trạng thái mặc định là đang xử lý
        ]);
        $user = User::find($request->user_id); // Lấy người dùng từ cơ sở dữ liệu
        if ($user) {
            $user->cart()->delete(); // Xóa tất cả các mục trong giỏ hàng
        }
        
        $vnp_Amount = $order->totalorder * 100;

        
        
        $vnp_TxnRef =  $order->order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
        $vnp_OrderInfo = "thanhtoanhoadon";
        $vnp_OrderType = "Thoitrang";
        
        $vnp_Locale = "VN";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
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
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            // vui lòng tham khảo thêm tại code demo
        
    }
    public function vnpayReturn(Request $request)
    {
        $vnpay_data = $request->all();
        // Kiểm tra mã phản hồi từ VNPay
        if ($vnpay_data['vnp_ResponseCode'] == '00') {
            // Giao dịch thành công
            $order = Order::where('vnpay_order_id', $vnpay_data['vnp_TxnRef'])->first();
            if (!$order) {
                return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
            }
    
            // Kiểm tra người dùng
            $user = User::find($vnpay_data['user_id']);
            if (!$user) {
                Log::error('User not found', ['user_id' => $vnpay_data['user_id']]);
                return response()->json(['success' => false, 'message' => 'Người dùng không tồn tại'], 404);
            }
            // Xoá giỏ hàng của người dùng
            $user->cart()->delete();
    
            // Cập nhật trạng thái thanh toán và lưu thông tin thanh toán vào cơ sở dữ liệu
            
            $order->shipping_status_id = "1"; // Giả sử trạng thái '1' là đã thanh toán
            $order->shipping_method_id = "1"; // Giả sử trạng thái '1' là phương thức vận chuyển mặc định
            $order->status = '3'; // Giả sử trạng thái '1' là "Đã thanh toán"
            $order->vnpay_payment_data = json_encode($vnpay_data); // Lưu thông tin trả về từ VNPay
            $order->save();
    
            // Phản hồi lại cho người dùng
            return response()->json([
                'message' => 'Thanh toán thành công',
                'order_id' => $order->id,
                'transaction_ref' => $vnpay_data['vnp_TxnRef']
            ], 200);
        } else {
            // Xử lý khi giao dịch thất bại
            return response()->json(['message' => 'Thanh toán thất bại, mã lỗi: ' . $vnpay_data['vnp_ResponseCode']], 400);
        }
    }
    
}
