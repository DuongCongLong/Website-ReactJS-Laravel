import  axiosInstance  from "./axiosInstance";

export const contactApi = {
    // Lấy tất cả liên hệ (GET)
    getAll(params) {
        const url = "/contacts";
        return axiosInstance.get(url, { params });
    },
    // Lấy một liên hệ theo ID (GET)
    get(id) {
        const url = `/contacts/${id}`;
        return axiosInstance.get(url);
    },
    // Thêm một liên hệ mới (POST)
    add(data) {
        const url = "/contacts";
        return axiosInstance.post(url, data);
    },
    // Cập nhật thông tin liên hệ (PUT)
    update(id, data) {
        const url = `/contacts/${id}`;
        return axiosInstance.put(url, data);
    },
    // Xóa liên hệ (DELETE)
    del(id) {
        const url = `/contacts/${id}`;
        return axiosInstance.delete(url);
    },
};