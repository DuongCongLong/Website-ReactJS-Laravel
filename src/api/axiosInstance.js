import axios from "axios";
import AppUrl from "./AppURL";
import store from "../state/store";

const axiosInstance = axios.create({
    baseURL: AppUrl.BaseURL,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        method: "POST",
    },
});

// Initial token setup
const token = store.getState().user.token;
if (token) {
    axiosInstance.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

// Update Authorization header on token changes
store.subscribe(() => {
    const newToken = store.getState().user.token;
    if (newToken) {
        axiosInstance.defaults.headers.common["Authorization"] = `Bearer ${newToken}`;
    } else {
        delete axiosInstance.defaults.headers.common["Authorization"];
    }
});

// Response interceptor to handle errors
axiosInstance.interceptors.request.use(
(config) => {
const token = localStorage.getItem("token"); // Hoặc từ Redux store
if (token) {
config.headers. Authorization = `Bearer ${token}`;
}
return config;
},
(error) => {
return Promise.reject(error);
}
);
export default axiosInstance;