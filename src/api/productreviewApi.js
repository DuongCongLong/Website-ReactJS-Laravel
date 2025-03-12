import axiosInstance from "./axiosInstance";

export const productReviewApi = {
    // Lấy tất cả đánh giá sản phẩm (GET)
    getAll(params) {
        var url = "/productreview";
        return axiosInstance.get(url, { params });
    },
    // Lấy một đánh giá sản phẩm theo ID (GET)
    get(id) {
        var url = `/productreview/${id}`;
        return axiosInstance.get(url);
    },    
    // Thêm một đánh giá sản phẩm mới (POST)
    add(data) {
        var url = "/productreview";
        return axiosInstance.post(url, data);
    },
    // Cập nhật đánh giá sản phẩm (PUT)
    update(id, data) {
        var url = `/productreview/${id}`;
        return axiosInstance.put(url, data);
    },
    // Xóa đánh giá sản phẩm (DELETE)
    del(id) {
        var url = `/productreview/${id}`;
        return axiosInstance.delete(url);
    }
};