import axiosInstance from "./axiosInstance";

export const categoryApi = {
    getAll(params) {
        var url = "/categories"; // Đường dẫn đến API để lấy tất cả danh mục
        return axiosInstance.get(url, { params });
    },
    get(id, params) {
        var url = `/categories/${id}`; // Đường dẫn để lấy một danh mục theo id
        return axiosInstance.get(url, { params });
    },
    add(data) {
        var url = `/categories`; // Đường dẫn để thêm danh mục mới
        return axiosInstance.post(url, data);
    },
    update(id, data) {
        var url = `/categories/${id}`; // Đường dẫn để cập nhật danh mục
        return axiosInstance.put(url, data);
    },
    del(id) {
        var url = `/categories/${id}`; // Đường dẫn để xóa danh mục
        return axiosInstance.delete(url);
    },
    getProductCount(id) {
        var url = `/categories/${id}/products/count`; // Đường dẫn để lấy số lượng sản phẩm trong danh mục
        return axiosInstance.get(url);
    },
};
