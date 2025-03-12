import axiosInstance from "./axiosInstance";

export const menuApi = {
    index(params) {
        var url = "/menus";
        return axiosInstance.get(url, { params });
    }
};
