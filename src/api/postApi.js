import axiosInstance from "./axiosInstance";

export const postApi = {
    index(params) {
        var url = "/posts";
        return axiosInstance.get(url, { params });
    },
    show(id) {  // Sửa lại để nhận ID và truy vấn đúng URL
        var url = `/post/${id}`;  // Đảm bảo sử dụng đúng URL với ID
        return axiosInstance.get(url);
    }
};
