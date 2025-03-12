import React from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";

export default function Service() {
  return (
    <div>
      <div>
        {/* Bắt đầu phần đầu trang */}
        <Header/>
        {/* Kết thúc phần đầu trang */}
        {/* Bắt đầu tìm kiếm trên cùng */}
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
        {/* Kết thúc tìm kiếm trên cùng */}
        {/* Bắt đầu phần tiêu đề tất cả */}
        <div className="all-title-box">
          <div className="container">
            <div className="row">
              <div className="col-lg-12">
                <h2>Dịch vụ</h2>
                <ul className="breadcrumb">
                  <li className="breadcrumb-item">
                    <a href="#">Trang chủ</a>
                  </li>
                  <li className="breadcrumb-item active">Dịch vụ</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        {/* Kết thúc phần tiêu đề tất cả */}
        {/* Bắt đầu dịch vụ */}
        <div className="services-box-main">
          <div className="container">
            <div className="row my-5">
              <div className="col-sm-6 col-lg-4">
                <div className="service-block-inner">
                  <h3>SỨ MỆNH CỦA CHÚNG TÔI</h3>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.{" "}
                  </p>
                </div>
              </div>
              <div className="col-sm-6 col-lg-4">
                <div className="service-block-inner">
                  <h3>TẦM NHÌN CỦA CHÚNG TÔI</h3>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.{" "}
                  </p>
                </div>
              </div>
              <div className="col-sm-6 col-lg-4">
                <div className="service-block-inner">
                  <h3>PHIẾU PHÁP CỦA CHÚNG TÔI</h3>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.{" "}
                  </p>
                </div>
              </div>
              <div className="col-sm-6 col-lg-4">
                <div className="service-block-inner">
                  <h3>Chúng tôi được tin tưởng</h3>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.{" "}
                  </p>
                </div>
              </div>
              <div className="col-sm-6 col-lg-4">
                <div className="service-block-inner">
                  <h3>Chúng tôi là chuyên nghiệp</h3>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.{" "}
                  </p>
                </div>
              </div>
              <div className="col-sm-6 col-lg-4">
                <div className="service-block-inner">
                  <h3>CÂU CHUYỆN CỦA CHÚNG TÔI</h3>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.{" "}
                  </p>
                </div>
              </div>
            </div>
            <div className="row my-4">
              <div className="col-12">
                <h2 className="noo-sh-title">Gặp gỡ đội ngũ của chúng tôi</h2>
              </div>
              <div className="col-sm-6 col-lg-3">
                <div className="hover-team">
                  <div className="our-team">
                    <img src="images/img-1.jpg" alt />
                    <div className="team-content">
                      <h3 className="title">Williamson</h3>
                      <span className="post">Nhà phát triển web</span>
                    </div>
                    <ul className="social">
                      <li>
                        <a href="#" className="fab fa-facebook" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-twitter" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-google-plus" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-youtube" />
                      </li>
                    </ul>
                    <div className="icon">
                      <i className="fa fa-plus" aria-hidden="true" />
                    </div>
                  </div>
                  <div className="team-description">
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Praesent urna diam, maximus ut ullamcorper quis, placerat
                      id eros. Duis semper justo sed condimentum rutrum. Nunc
                      tristique purus turpis. Maecenas vulputate.{" "}
                    </p>
                  </div>
                  <hr className="my-0" />
                </div>
              </div>
              <div className="col-sm-6 col-lg-3">
                <div className="hover-team">
                  <div className="our-team">
                    <img src="images/img-2.jpg" alt />
                    <div className="team-content">
                      <h3 className="title">Kristiana</h3>
                      <span className="post">Nhà phát triển web</span>
                    </div>
                    <ul className="social">
                      <li>
                        <a href="#" className="fab fa-facebook" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-twitter" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-google-plus" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-youtube" />
                      </li>
                    </ul>
                    <div className="icon">
                      <i className="fa fa-plus" aria-hidden="true" />
                    </div>
                  </div>
                  <div className="team-description">
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Praesent urna diam, maximus ut ullamcorper quis, placerat
                      id eros. Duis semper justo sed condimentum rutrum. Nunc
                      tristique purus turpis. Maecenas vulputate.{" "}
                    </p>
                  </div>
                  <hr className="my-0" />
                </div>
              </div>
              <div className="col-sm-6 col-lg-3">
                <div className="hover-team">
                  <div className="our-team">
                    <img src="images/img-3.jpg" alt />
                    <div className="team-content">
                      <h3 className="title">Steve Thomas</h3>
                      <span className="post">Nhà phát triển web</span>
                    </div>
                    <ul className="social">
                      <li>
                        <a href="#" className="fab fa-facebook" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-twitter" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-google-plus" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-youtube" />
                      </li>
                    </ul>
                    <div className="icon">
                      <i className="fa fa-plus" aria-hidden="true" />
                    </div>
                  </div>
                  <div className="team-description">
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Praesent urna diam, maximus ut ullamcorper quis, placerat
                      id eros. Duis semper justo sed condimentum rutrum. Nunc
                      tristique purus turpis. Maecenas vulputate.{" "}
                    </p>
                  </div>
                  <hr className="my-0" />
                </div>
              </div>
              <div className="col-sm-6 col-lg-3">
                <div className="hover-team">
                  <div className="our-team">
                    <img src="images/img-1.jpg" alt />
                    <div className="team-content">
                      <h3 className="title">Williamson</h3>
                      <span className="post">Nhà phát triển web</span>
                    </div>
                    <ul className="social">
                      <li>
                        <a href="#" className="fab fa-facebook" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-twitter" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-google-plus" />
                      </li>
                      <li>
                        <a href="#" className="fab fa-youtube" />
                      </li>
                    </ul>
                    <div className="icon">
                      <i className="fa fa-plus" aria-hidden="true" />
                    </div>
                  </div>
                  <div className="team-description">
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Praesent urna diam, maximus ut ullamcorper quis, placerat
                      id eros. Duis semper justo sed condimentum rutrum. Nunc
                      tristique purus turpis. Maecenas vulputate.{" "}
                    </p>
                  </div>
                  <hr className="my-0" />
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* Kết thúc dịch vụ */}
        {/* Bắt đầu phần chân trang */}
        <Footer/>
        {/* Kết thúc phần chân trang */}
      </div>
    </div>
  );
}
