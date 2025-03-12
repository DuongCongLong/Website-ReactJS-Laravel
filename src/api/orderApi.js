import axiosInstance from "./axiosInstance";
class OrderApiRequest {
    checkout (payload) {
        return axiosInstance.post("/order/checkout", payload);
    }
    completeOrder(payload) {
        return axiosInstance.post("/order/vnpay_return", payload);
    }
}
export default new OrderApiRequest();