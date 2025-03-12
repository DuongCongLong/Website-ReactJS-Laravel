import axios from 'axios';

const API_URL = 'http://localhost:8000/api';

// Cấu hình axios instance
const axiosInstance = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Thêm token vào tất cả request
axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Xử lý lỗi chung
axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      //console.error('Unauthorized. Redirecting to login...');
      localStorage.removeItem('token');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

// Hàm đăng ký
export const register = async (name, email, password) => {
  try {
    const response = await axiosInstance.post('/register', { name, email, password });
    return response;
  } catch (error) {
    console.error('Error during registration:', error);
    throw error;
  }
};

// Hàm đăng nhập
export const login = async (email, password) => {
  try {
    const response = await axiosInstance.post('/login', { email, password });
    return response; // Trả về response đầy đủ từ API
  } catch (error) {
    console.error('Error during login:', error);
    throw error; // Ném lỗi nếu có
  }
};


// Hàm đăng xuất
export const logout = async () => {
  try {
    await axiosInstance.post('/logout');
  } catch (error) {
    console.error('Error during logout:', error);
  } finally {
    localStorage.removeItem('token');
  }
};

// Hàm lấy thông tin người dùng
export const getUserInfo = async () => {
  try {
    const response = await axiosInstance.get('/me');
    return response;
  } catch (error) {
    console.error('Error fetching user info:', error);
    throw error;
  }
};
export default login;
