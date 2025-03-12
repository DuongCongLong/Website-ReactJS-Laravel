import React, { useState } from "react";
import Header from "./Header";
import { contactApi } from "../api/contactApi";
import { toast } from "react-toastify";
import Footer from "./Footer";

export default function Contact() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [msg, setMsg] = useState("");
  const [error, setError] = useState("");
  const [isSuccess, setIsSuccess] = useState(false); // Thêm state isSuccess

  const getAuthData = () => {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("user_id");
    console.log("user_id:", userId); // In ra giá trị thực của userId
    const email = localStorage.getItem("userEmail"); // Lấy email đã lưu trong localStorage
    return { token, userId, email }; // Trả về token, userId và email
  };

  // Hàm xử lý gửi tin nhắn
  const handleSubmit = async (event) => {
    event.preventDefault();

    const { token, userId, email: storedEmail } = getAuthData();

    // Kiểm tra nếu không có token hoặc user_id
    if (!token || !userId) {
      setError("Vui lòng đăng nhập để gửi tin nhắn.");
      setIsSuccess(false); // Đặt lại trạng thái isSuccess khi có lỗi
      return;
    }

    if (email !== storedEmail) {
      setError("Email không khớp với tài khoản đã đăng nhập.");
      setIsSuccess(false);
      return;
    }

    // Nếu có token và user_id, tiếp tục gửi tin nhắn
    const data = {
      name,
      email: storedEmail,
      msg,
      user_id: userId, // Gửi user_id để xác định người dùng
    };

    try {
      await contactApi.add(data); // Gọi API gửi tin nhắn
      setError(""); // Xóa thông báo lỗi nếu gửi thành công
      setIsSuccess(true); // Đặt trạng thái thành công khi gửi tin nhắn thành công

      // Reset form sau khi gửi thành công
      setName("");
      setEmail("");
      setMsg("");
      toast.success("Tin nhắn đã được gửi thành công!");
    } catch (err) {
      setError("Có lỗi xảy ra khi gửi dữ liệu.");
      setIsSuccess(false); // Đặt lại trạng thái isSuccess khi có lỗi
      toast.error("Có lỗi xảy ra khi gửi tin nhắn.");
    }
  };

  return (
    <div>
      <div>
        {/* Topbar Start */}
        <Header />
        {/* Navbar End */}
        {/* Breadcrumb Start */}
        <div className="container-fluid">
          <div className="row px-xl-5">
            <div className="col-12">
              <nav className="breadcrumb bg-light mb-30">
                <a className="breadcrumb-item text-dark" href="#">
                  Trang chủ
                </a>
                <span className="breadcrumb-item active">Liên hệ</span>
              </nav>
            </div>
          </div>
        </div>
        {/* Breadcrumb End */}
        {/* Contact Start */}
        <div className="container-fluid">
          <h2 className="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span className="bg-secondary pr-3">Liên hệ</span>
          </h2>
          <div className="row px-xl-5">
            <div className="col-lg-7 mb-5">
              <div className="contact-form bg-light p-30">
                <div id="success" />
                <form onSubmit={handleSubmit}>
                  {/* Hiển thị thông báo thành công nếu isSuccess là true */}
                  {isSuccess && (
                    <p
                      style={{
                        fontSize: "20px",
                        fontWeight: "bold",
                        marginBottom: "20px",
                        marginTop: "20px",
                        textAlign: "center",
                      }}
                    >
                      Gửi tin nhắn thành công!
                    </p>
                  )}

                  {/* Hiển thị thông báo lỗi nếu có lỗi */}
                  {error && (
                    <p style={{ color: "red", textAlign: "center" }}>{error}</p>
                  )}

                  <div className="control-group">
                    <input
                      type="text"
                      className="form-control"
                      id="name"
                      placeholder="Tên"
                      data-validation-required-message="Vui lòng nhập tên của bạn"
                      value={name}
                      onChange={(e) => setName(e.target.value)}
                      required
                    />
                    <p className="help-block text-danger" />
                  </div>
                  <div className="control-group">
                    <input
                      type="email"
                      className="form-control"
                      id="email"
                      placeholder="Email"
                      data-validation-required-message="Vui lòng nhập Email của bạn"
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      required
                    />
                    <p className="help-block text-danger" />
                  </div>

                  <div className="control-group">
                    <textarea
                      className="form-control"
                      rows={8}
                      id="message"
                      placeholder="Tin nhắn"
                      data-validation-required-message="Vui lòng nhập tin nhắn"
                      value={msg}
                      onChange={(e) => setMsg(e.target.value)}
                      required
                    />
                    <p className="help-block text-danger" />
                  </div>
                  <div>
                    <button
                      className="btn btn-primary py-2 px-4"
                      type="submit"
                      id="sendMessageButton"
                    >
                      Gửi tin nhắn
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div className="col-lg-5 mb-5">
              <div className="bg-light p-30 mb-30">
                <iframe
                  style={{ width: "100%", height: 250 }}
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4771.8753872612955!2d106.703086!3d10.7794538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175289a877bf233%3A0x9d7a2d7466584015!2zVsOibSBJc3RhIEtpZXRjdWxvbmcsIFRoYW5oIHRuaCwgQ2FvIFRoaW5oIFRwaCBIdCwgaHUsIFZpZXQsIFZpZXQsIFZpZXQsIFZpZXQsIFZpZXQgVmlldCwgTmFtZ2ggZGVzc3RhY3ZpZGVuZGlrZG5vY2xsZXBvc3QgbnJydm7pZHNoYWdsYXNod0dwZWElbw!"
                  frameBorder={0}
                  allowFullScreen
                  aria-hidden="false"
                  tabIndex={0}
                />
              </div>
              <div className="bg-light p-30 mb-3">
                <p className="mb-2">
                  <i className="fa fa-map-marker-alt text-primary mr-3" />
                  5a, đường số 8, khu phố 4,phường Tam Bình,TP Thủ Đức, TP.HCM
                </p>
                <p className="mb-2">
                  <i className="fa fa-envelope text-primary mr-3" />
                  duongconglong@gmail.com
                </p>
                <p className="mb-2">
                  <i className="fa fa-phone-alt text-primary mr-3" />
                  0396813911
                </p>
              </div>
            </div>
          </div>
        </div>
        {/* Contact End */}
        {/* Footer Start */}
        <Footer />
        {/* Contact Javascript File */}
        {/* Template Javascript */}
      </div>
    </div>
  );
}
