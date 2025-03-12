import React, { useState } from 'react';
import { toast } from 'react-toastify';
import { useNavigate } from 'react-router-dom';
import axiosInstance from '../api/axiosConfig';

export default function Register() {
  const navigate = useNavigate();
  
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user'
  });

  const [errors, setErrors] = useState({});

  const handleRegister = async (e) => {
    e.preventDefault();
    
    // Kiểm tra validate
    const newErrors = {};
    if (!formData.name) newErrors.name = "Tên không được để trống";
    if (!formData.email) newErrors.email = "Email không được để trống";
    if (!formData.password) newErrors.password = "Mật khẩu không được để trống";
    if (formData.password !== formData.password_confirmation) {
      newErrors.password_confirmation = "Mật khẩu không khớp";
    }

    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      return;
    }

    try {
      const response = await axiosInstance.post('/register', formData);
      
      // Lưu token vào localStorage
      localStorage.setItem('token', response.data.token);
      
      // Thông báo đăng ký thành công
      toast.success('Đăng ký tài khoản thành công!');
      
      // Chuyển hướng đến trang đăng nhập hoặc trang chủ
      navigate('/login');
    } catch (error) {
      // Xử lý lỗi từ server
      if (error.response && error.response.data.errors) {
        const serverErrors = error.response.data.errors;
        setErrors(serverErrors);
        
        // Hiển thị thông báo lỗi chi tiết
        Object.values(serverErrors).forEach(errorMsg => {
          toast.error(errorMsg);
        });
      } else {
        toast.error('Có lỗi xảy ra. Vui lòng thử lại.');
      }
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prevState => ({
      ...prevState,
      [name]: value
    }));

    // Xóa error khi người dùng bắt đầu nhập
    if (errors[name]) {
      setErrors(prevErrors => ({
        ...prevErrors,
        [name]: undefined
      }));
    }
  };

  return (
    <div className="container-fluid bg-light vh-100">
      <div className="row justify-content-center align-items-center h-100">
        <div className="col-md-6 col-lg-4">
          <div className="card shadow">
            <div className="card-header text-center">
              <h4 className="font-weight-bold">Đăng Ký</h4>
            </div>
            <div className="card-body">
              <form onSubmit={handleRegister}>
                <div className="form-group mb-3">
                  <label htmlFor="name" className="form-label">Tên người dùng</label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                    placeholder="Nhập tên người dùng"
                    value={formData.name}
                    onChange={handleChange}
                  />
                  {errors.name && <div className="invalid-feedback">{errors.name}</div>}
                </div>

                <div className="form-group mb-3">
                  <label htmlFor="email" className="form-label">Email</label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                    placeholder="Nhập email của bạn"
                    value={formData.email}
                    onChange={handleChange}
                  />
                  {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                </div>

                <div className="form-group mb-3">
                  <label htmlFor="password" className="form-label">Mật khẩu</label>
                  <input
                    type="password"
                    id="password"
                    name="password"
                    className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                    placeholder="Nhập mật khẩu của bạn"
                    value={formData.password}
                    onChange={handleChange}
                  />
                  {errors.password && <div className="invalid-feedback">{errors.password}</div>}
                </div>

                <div className="form-group mb-3">
                  <label htmlFor="password_confirmation" className="form-label">Nhập lại mật khẩu</label>
                  <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    className={`form-control ${errors.password_confirmation ? 'is-invalid' : ''}`}
                    placeholder="Nhập lại mật khẩu của bạn"
                    value={formData.password_confirmation}
                    onChange={handleChange}
                  />
                  {errors.password_confirmation && (
                    <div className="invalid-feedback">{errors.password_confirmation}</div>
                  )}
                </div>

                <button 
                  type="submit" 
                  className="btn btn-primary btn-block w-100"
                >
                  Đăng Ký
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}