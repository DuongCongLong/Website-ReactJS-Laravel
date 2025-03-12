import React from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";

export default function Myaccount() {
  return (
    <div>
      <div>
        {/* Bắt đầu phần Header */}
        <Header />
        {/* Kết thúc phần Header */}
        
        {/* Bắt đầu phần tiêu đề */}
        <div className="all-title-box">
          <div className="container">
            <div className="row">
              <div className="col-lg-12">
                <h2>Tài Khoản Của Tôi</h2>
                <ul className="breadcrumb">
                  <li className="breadcrumb-item">
                    <a href="/">Cửa Hàng</a>
                  </li>
                  <li className="breadcrumb-item active">Tài khoản của tôi</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        {/* Kết thúc phần tiêu đề */}

        {/* Bắt đầu phần tài khoản */}
        <div className="my-account-box-main">
          <div className="container">
            <div className="my-account-page">
              <div className="row">
                <div className="col-lg-4 col-md-12">
                  <div className="account-box">
                    <div className="service-box">
                      <div className="service-icon">
                        <a href="#">
                          <i className="fa fa-gift" />
                        </a>
                      </div>
                      <div className="service-desc">
                        <h4>Đơn Hàng Của Bạn</h4>
                        <p>Theo dõi, trả lại hoặc mua lại hàng hóa</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="col-lg-4 col-md-12">
                  <div className="account-box">
                    <div className="service-box">
                      <div className="service-icon">
                        <a href="#">
                          <i className="fa fa-lock" />
                        </a>
                      </div>
                      <div className="service-desc">
                        <h4>Đăng Nhập & Bảo Mật</h4>
                        <p>Chỉnh sửa đăng nhập, tên và số điện thoại</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="col-lg-4 col-md-12">
                  <div className="account-box">
                    <div className="service-box">
                      <div className="service-icon">
                        <a href="#">
                          <i className="fa fa-location-arrow" />
                        </a>
                      </div>
                      <div className="service-desc">
                        <h4>Địa Chỉ Của Bạn</h4>
                        <p>Chỉnh sửa địa chỉ cho đơn hàng và quà tặng</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="col-lg-4 col-md-12">
                  <div className="account-box">
                    <div className="service-box">
                      <div className="service-icon">
                        <a href="#">
                          <i className="fa fa-credit-card" />
                        </a>
                      </div>
                      <div className="service-desc">
                        <h4>Tùy Chọn Thanh Toán</h4>
                        <p>Chỉnh sửa hoặc thêm phương thức thanh toán</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="col-lg-4 col-md-12">
                  <div className="account-box">
                    <div className="service-box">
                      <div className="service-icon">
                        <a href="#">
                          <i className="fab fa-paypal" />
                        </a>
                      </div>
                      <div className="service-desc">
                        <h4>PayPal</h4>
                        <p>Xem các lợi ích và cài đặt thanh toán</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="col-lg-4 col-md-12">
                  <div className="account-box">
                    <div className="service-box">
                      <div className="service-icon">
                        <a href="#">
                          <i className="fab fa-amazon" />
                        </a>
                      </div>
                      <div className="service-desc">
                        <h4>Số Dư Amazon Pay</h4>
                        <p>Thêm tiền vào số dư của bạn</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="bottom-box">
                <div className="row">
                  {/* Các mục bên dưới */}
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* Kết thúc phần tài khoản */}

        {/* Bắt đầu phần Instagram Feed */}
        <div className="instagram-box">
          <div className="main-instagram owl-carousel owl-theme">
            {/* Các ảnh Instagram */}
          </div>
        </div>
        {/* Kết thúc phần Instagram Feed */}

        {/* Bắt đầu phần Footer */}
        <Footer />
        {/* Kết thúc phần Footer */}
        <a href="#" id="back-to-top" title="Back to top" style={{ display: "none" }}>
          ↑
        </a>
        {/* Tất cả các tập tin JS */}
        {/* Tất cả các plugin */}
      </div>
    </div>
  );
}
