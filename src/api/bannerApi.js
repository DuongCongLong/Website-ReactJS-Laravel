import axiosInstance from "./axiosInstance";

export const bannerApi = {
    index(params) {
        var url = "/banners";
        return axiosInstance.get(url, { params });
    }
};
