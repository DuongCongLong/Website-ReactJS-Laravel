import React from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";

export default function Contactus() {
  return (
    <div>
      <div>
        <Header />
        {/* Kết thúc Phần Đầu Trang */}
        {/* Bắt đầu Tìm Kiếm Đầu Trang */}
        <div className="top-search">
          <div className="container">
            <div className="input-group">
              <span className="input-group-addon">
                <i className="fa fa-search" />
              </span>
              <input
                type="text"
                className="form-control"
                placeholder="Tìm kiếm"
              />
              <span className="input-group-addon close-search">
                <i className="fa fa-times" />
              </span>
            </div>
          </div>
        </div>
        {/* Kết thúc Tìm Kiếm Đầu Trang */}
        {/* Bắt đầu Tất Cả Các Hộp Tiêu Đề */}
        <div className="all-title-box">
          <div className="container">
            <div className="row">
              <div className="col-lg-12">
                <h2>Liên Hệ Với Chúng Tôi</h2>
                <ul className="breadcrumb">
                  <li className="breadcrumb-item">
                    <a href="#">Trang Chủ</a>
                  </li>
                  <li className="breadcrumb-item active"> Liên Hệ Với Chúng Tôi </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        {/* Kết thúc Tất Cả Các Hộp Tiêu Đề */}
        {/* Bắt đầu Liên Hệ Với Chúng Tôi */}
        <div className="contact-box-main">
          <div className="container">
            <div className="row">
              <div className="col-lg-4 col-sm-12">
                <div className="contact-info-left">
                  <h2>THÔNG TIN LIÊN HỆ</h2>
                  <ul>
                    <li>
                      <p>
                        <i className="fas fa-map-marker-alt" />
                        Địa chỉ: Michael I. Days 3756 <br />
                        Preston Street Wichita,
                        <br /> KS 67213{" "}
                      </p>
                    </li>
                    <li>
                      <p>
                        <i className="fas fa-phone-square" />
                        Điện thoại: <a href="tel:+1-888705770">+1-888 705 770</a>
                      </p>
                    </li>
                    <li>
                      <p>
                        <i className="fas fa-envelope" />
                        Email:{" "}
                        <a href="mailto:contactinfo@gmail.com">
                          contactinfo@gmail.com
                        </a>
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
              <div className="col-lg-8 col-sm-12">
                <div className="contact-form-right">
                  <h2>LIÊN HỆ NGAY</h2>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                    odio justo, ultrices ac nisl sed, lobortis porta elit. Fusce
                    in metus ac ex venenatis ultricies at cursus mauris.
                  </p>
                  <form id="contactForm">
                    <div className="row">
                      <div className="col-md-12">
                        <div className="form-group">
                          <input
                            type="text"
                            className="form-control"
                            id="name"
                            name="name"
                            placeholder="Tên của bạn"
                            required
                            data-error="Vui lòng nhập tên của bạn"
                          />
                          <div className="help-block with-errors" />
                        </div>
                      </div>
                      <div className="col-md-12">
                        <div className="form-group">
                          <input
                            type="text"
                            placeholder="Email của bạn"
                            id="email"
                            className="form-control"
                            name="name"
                            required
                            data-error="Vui lòng nhập email của bạn"
                          />
                          <div className="help-block with-errors" />
                        </div>
                      </div>
                     
                      <div className="col-md-12">
                        <div className="form-group">
                          <textarea
                            className="form-control"
                            id="message"
                            placeholder="Tin nhắn của bạn"
                            rows={4}
                            data-error="Viết tin nhắn của bạn"
                            required
                            defaultValue={""}
                          />
                          <div className="help-block with-errors" />
                        </div>
                        <div className="submit-button text-center">
                          <button
                            className="btn hvr-hover"
                            id="submit"
                            type="submit">
                            Gửi Tin Nhắn
                          </button>
                          <div
                            id="msgSubmit"
                            className="h3 text-center hidden"
                          />
                          <div className="clearfix" />
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* Kết thúc Giỏ Hàng */}
        {/* Bắt đầu Instagram Feed */}
        <div className="instagram-box">
          <div className="main-instagram owl-carousel owl-theme">
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-01.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-02.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-03.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-04.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-05.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-06.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-07.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-08.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-09.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-05.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* Kết thúc Instagram Feed */}
      </div>
      <Footer />
    </div>
  );
}
