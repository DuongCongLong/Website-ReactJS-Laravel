import axiosInstance from "./axiosInstance";

export const productApi = {
    getAll(params) {
        var url = "/products";
        return axiosInstance.get(url, { params });
    },
    getAllproduct(params) {
        var url = "/product";
        return axiosInstance.get(url, { params });
    },
    get(id, params) {
        var url = `/products/${id}`;
        return axiosInstance.get(url, { params });
    },
    getByCategory(categoryId) {
        var url = `/products/category/${categoryId}`;
        return axiosInstance.get(url);
    },
    getProductsByBrand(id) {
        var url = `/products/${id}/related-by-brand`;
        return axiosInstance.get(url);
    },
    getReviewCount(id) {
        var url = `/products/${id}/reviews/count`;
        return axiosInstance.get(url);
    },
    add(data) {
        var url = `/products`;
        return axiosInstance.post(url, data);
    },
    update(id, data) {
        var url = `/products/${id}`;
        return axiosInstance.put(url, data);
    },
    del(id) {
        var url = `/products/${id}`;
        return axiosInstance.delete(url);
    },
};
