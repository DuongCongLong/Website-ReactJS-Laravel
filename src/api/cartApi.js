import axiosInstance from "./axiosInstance";

class CartApiRequest {
    // Thêm sản phẩm vào giỏ hàng
    addToCart(payload) {
        return axiosInstance.post("/cart/add", payload);
    }

    // Lấy giỏ hàng của người dùng
    getCartByUserId(userId) {
        const token = localStorage.getItem('token');
        return axiosInstance.get(`/cart/${userId}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    updateCart(payload) {
        return axiosInstance.post("/cart/quantity", payload);
    }

    
    // Xóa sản phẩm khỏi giỏ hàng
    // Thay đổi từ DELETE sang POST
    removeCartItem(payload) {
        return axiosInstance.delete("/cart/delete", {
            data: payload, // Chuyển dữ liệu vào `data` để gửi kèm với DELETE request
        });
    }
    

    // Đồng bộ giỏ hàng giữa frontend và backend
    syncCart(payload) {
        const token = localStorage.getItem('token');
        return axiosInstance.post("/cart/sync", payload, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
    }
}

export default new CartApiRequest();
