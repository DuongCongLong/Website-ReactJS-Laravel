import axiosInstance from "./axiosInstance";

export const brandApi = {
    getAll(params) {
        var url = "/brands";
        return axiosInstance.get(url, { params });
    },
    get(id, params) {
        var url = `/brands/${id}`;
        return axiosInstance.get(url, { params });
    },
    add(data) {
        var url = `/brands`;
        return axiosInstance.post(url, data);
    },
    update(id, data) {
        var url = `/brands/${id}`;
        return axiosInstance.put(url, data);
    },
    del(id) {
        var url = `/brands/${id}`;
        return axiosInstance.delete(url);
    },
};
