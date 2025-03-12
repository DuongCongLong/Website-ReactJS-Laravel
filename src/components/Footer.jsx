import React from "react";

// Xuất Footer như một component mặc định
export default function Footer() {
  return (
    <div>
      {/* Phần chân trang với nền tối và padding phía trên */}
      <div className="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div className="row px-xl-5 pt-5">
          {/* Thông tin liên hệ */}
          <div className="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <h5 className="text-secondary text-uppercase mb-4">
              Liên hệ với chúng tôi
            </h5>
            <p className="mb-4">
              Thông tin đầy đủ về địa chỉ này. Vui lòng xem thông tin liên lạc
              bên dưới.
            </p>
            <p className="mb-2">
              <i className="fa fa-map-marker-alt text-primary mr-3" />
             5a, đường số 8, khu phố 4,phường Tam Bình,TP Thủ Đức, TP.HCM
            </p>
            <p className="mb-2">
              <i className="fa fa-envelope text-primary mr-3" />
              duongconglong@gmail.com
            </p>
            <p className="mb-0">
              <i className="fa fa-phone-alt text-primary mr-3" />
              0396813911
            </p>
          </div>

          {/* Các liên kết nhanh cho cửa hàng */}
          <div className="col-lg-8 col-md-12">
            <div className="row">
              {/* Liên kết nhanh đến các mục trong cửa hàng */}
              <div className="col-md-4 mb-5">
                <h5 className="text-secondary text-uppercase mb-4">
                  Cửa Hàng Nhanh
                </h5>
                <div className="d-flex flex-column justify-content-start text-left">
                  <a className="text-secondary mb-2" href="/">
                    <i className="fa fa-angle-right mr-2" />
                    Trang chủ
                  </a>
                  <a className="text-secondary mb-2" href="/shop">
                    <i className="fa fa-angle-right mr-2" />
                    Cửa hàng của chúng tôi
                  </a>
                  <a className="text-secondary mb-2" href="/cart">
                    <i className="fa fa-angle-right mr-2" />
                    Giỏ hàng
                  </a>
                  <a className="text-secondary mb-2" href="/checkout">
                    <i className="fa fa-angle-right mr-2" />
                    Thanh toán
                  </a>
                  <a className="text-secondary" href="/contact">
                    <i className="fa fa-angle-right mr-2" />
                    Liên hệ với chúng tôi
                  </a>
                </div>
              </div>

              {/* Phần đăng ký nhận tin tức */}
              <div className="col-md-4 mb-5">
                <h5 className="text-secondary text-uppercase mb-4">
                  Đăng ký Nhận Tin
                </h5>
                <p>Nhập email của bạn để nhận thông tin cập nhật.</p>
                <form action>
                  <div className="input-group">
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Nhập địa chỉ email của bạn"
                    />
                    <div className="input-group-append">
                      <button className="btn btn-primary">Đăng ký</button>
                    </div>
                  </div>
                </form>
              </div>
              <div className="col-md-4 mb-5">
                <h5 className="text-secondary text-uppercase mb-4">
                  Theo dõi chúng tôi
                </h5>
                <p>Nhấn để theo dõi chúng tôi qua:</p>
                <div className="d-flex ml-5">
                  <a
                    className="btn btn-primary btn-square mr-2"
                    href="#"
                    target="_blank"
                  >
                    <span
                      className="font-weight-bold"
                      style={{ fontSize: "20px" }}
                    >
                      T
                    </span>
                  </a>

                  <a
                    className="btn btn-primary btn-square mr-2"
                    href="#"
                    target="_blank"
                  >
                    <i className="fab fa-facebook-f" />
                  </a>

                  <a
                    className="btn btn-primary btn-square"
                    href="https://zalo.me/"
                    target="_blank"
                  >
                    <span
                      className="font-weight-bold"
                      style={{ fontSize: "20px" }}
                    >
                      Zalo
                    </span>
                  </a>
                </div>
              </div>

              {/* Liên kết thông tin tài khoản */}
            </div>
          </div>
        </div>

        {/* Thêm thông tin bản quyền và thanh toán */}
        <div
          className="row border-top mx-xl-5 py-4"
          style={{ borderColor: "rgba(256, 256, 256, .1) !important" }}
        >
          <div className="col-md-6 px-xl-0">
            <p className="mb-md-0 text-center text-md-left text-secondary">
              ©{" "}
              <a className="text-primary" href="#">
                Domain
              </a>
              . Bản quyền đã được bảo lưu. Thiết kế bởi HTML Codex
              <a className="text-primary" href="https://htmlcodex.com">
                 {/* HTML Codex */}
              </a>
            </p>
          </div>
          <div className="col-md-6 px-xl-0 text-center text-md-right">
            <img
              className="img-fluid"
              src="img/payments.png"
              alt="Thanh toán"
            />
          </div>
        </div>
      </div>

      {/* Nút quay về đầu trang */}
      <a href="#" className="btn btn-primary back-to-top">
        <i className="fa fa-angle-double-up" />
      </a>
    </div>
  );
}
