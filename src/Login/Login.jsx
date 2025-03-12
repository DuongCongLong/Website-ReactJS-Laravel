import React, { useState } from 'react';
import { login } from '../api/AuthApi';
import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';

export default function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();

    if (!email || !password) {
      toast.error('Vui lòng nhập email và mật khẩu!');
      return;
    }
    
    try {
      const res = await login(email, password);
      console.log('API Response:', res);
      if (res.data?.token && res.data?.user?.name) { 
        // Kiểm tra token và tên người dùng từ phản hồi API
        localStorage.setItem('token', res.data.token);
        localStorage.setItem("user_id", res.data.user.id);
        localStorage.setItem('userName', res.data.user.name); 
        localStorage.setItem('userEmail', res.data.user.email);
        localStorage.setItem('role', res.data.user.role);
        localStorage.setItem('isLoggedIn', 'true'); // Lưu trạng thái đăng nhập
        toast.success('Đăng nhập thành công!');
        const userRole = res.data.user.role;
        if (userRole === 'admin') {
          window.location.href = 'http://127.0.0.1:8000/admin';
        } else {
          navigate('/');  // Nếu là user, điều hướng đến trang home
        }
      } else {
        toast.error('Thông tin đăng nhập không hợp lệ.');
      }

    } catch (error) {
      console.error('Error during login:', error);
      toast.error(error.response?.data?.message || 'Đăng nhập thất bại. Vui lòng thử lại!');
    }
  };

  return (
    <div className="container-fluid bg-light vh-100">
      <div className="row justify-content-center align-items-center h-100">
        <div className="col-md-6 col-lg-4">
          <div className="card shadow">
            <div className="card-header text-center">
              <h4 className="font-weight-bold">Đăng Nhập</h4>
            </div>
            <div className="card-body">
              <form onSubmit={handleLogin}>
                <div className="form-group">
                  <label htmlFor="email">Email</label>
                  <input
                    type="email"
                    className="form-control"
                    placeholder="Nhập email của bạn"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                  />
                </div>
                <div className="form-group">
                  <label htmlFor="password">Mật khẩu</label>
                  <input
                    type="password"
                    className="form-control"
                    placeholder="Nhập mật khẩu của bạn"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                  />
                </div>
                <button type="submit" className="btn btn-primary btn-block">
                  Đăng Nhập
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}