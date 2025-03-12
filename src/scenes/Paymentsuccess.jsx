import React, { useEffect } from "react";
import { Link, useLocation } from "react-router-dom";
import AppUrl from "../api/AppURL";
import Header from "../components/Header";
import Footer from "../components/Footer";
import * as XLSX from "xlsx"; // Import thư viện xlsx

export default function PaymentSuccess() {
  const location = useLocation();
  const { cart, total, totalQuantity } = location.state || {};

  // Hàm xử lý xuất Excel
  const exportToExcel = () => {
    const data = cart.map((item) => ({
      ["Sản phẩm"]: item.product_name, // Thêm URL ảnh thay vì tên sản phẩm
      ["Số lượng"]: item.quantity,
      ["Giá"]: item.price.toLocaleString() + " VNĐ",
      ["Tổng"]: (item.price * item.quantity).toLocaleString() + " VNĐ",
    }));
  
    // Thêm dòng tổng cuối cùng
    data.push({
      "Sản phẩm": "Tổng cộng",
      "Số lượng": totalQuantity,
      "Giá": "",
      "Tổng": total.toLocaleString() + " VNĐ",
    });
  
    const worksheet = XLSX.utils.json_to_sheet(data);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Đơn Hàng");
  
    // Xuất file Excel
    XLSX.writeFile(workbook, "DonHang.xlsx");
  };
  
  return (
    <div>
      <Header />
      <div className="container">
        <h2>Thanh toán thành công!</h2>
        <div className="cart-box-main">
          <div className="checkout-order">
            <div className="title-left">
              <h3>Đơn hàng của tôi</h3>
            </div>
            <div className="row border-bottom">
              <div className="col-md-3">
                <h7 className="mb-3">Sản phẩm</h7>
              </div>
              <div className="col-md-3">
                <h7 className="mb-3">Số lượng</h7>
              </div>
              <div className="col-md-3">
                <h7 className="mb-3">Giá</h7>
              </div>
              <div className="col-md-3">
                <h7 className="mb-3">Tổng</h7>
              </div>
            </div>

            {cart.map((item, index) => (
              <div key={index} className="row border-bottom align-items-center">
                <div className="col-md-2 d-flex align-items-center ml-5">
                  <div className="product-item d-flex align-items-center justify-content-center">
                    <img
                      src={`${AppUrl.ImageUrl}/images/products/${item.image}`}
                      alt={item.name}
                      style={{
                        width: "100px",
                        height: "150px",
                        marginRight: "10px",
                        objectFit: "cover",
                      }}
                    />
                    <span>{item.name}</span>
                  </div>
                </div>
                <div className="col-md">
                  <p>{item.quantity}</p>
                </div>
                <div className="col-md-3">
                  <p className="text">{item.price.toLocaleString()} VNĐ</p>
                </div>
                <div className="col-md-3">
                  <p className="text" style={{ fontWeight: "bold" }}>
                    {(item.price * item.quantity).toLocaleString()} VNĐ
                  </p>
                </div>
              </div>
            ))}

            <div className="row mt-3">
              <div className="col-md">
                <h5 className="mb-3">
                  Tổng số tiền ({totalQuantity} sản phẩm)
                </h5>
              </div>
              <div className="col-md-3">
                <p
                  className="text-success"
                  style={{ fontWeight: "bold", fontSize: "18px" }}
                >
                  {total.toLocaleString()} VNĐ
                </p>
              </div>
            </div>

            {/* Nút xuất Excel */}
            <button
              onClick={exportToExcel}
              style={{
                fontSize: "16px",
                fontWeight: "bold",
                padding: "10px 20px",
                backgroundColor: "#28a745",
                color: "#fff",
                border: "none",
                borderRadius: "5px",
                cursor: "pointer",
                marginTop: "20px",
              }}
              onMouseOver={(e) => (e.target.style.backgroundColor = "#218838")}
              onMouseOut={(e) => (e.target.style.backgroundColor = "#28a745")}
            >
              Xuất Excel
            </button>
          </div>
        </div>
      </div>
      <Link
        to="/"
        style={{
          fontSize: "18px",
          fontWeight: "600",
          textDecoration: "none",
          backgroundColor: "#007bff",
          color: "#fff",
          padding: "12px 25px",
          borderRadius: "30px",
          display: "inline-block",
          textAlign: "center",
          boxShadow: "0 4px 8px rgba(0, 123, 255, 0.2)",
          transition: "all 0.3s ease",
        }}
        onMouseOver={(e) => {
          e.target.style.backgroundColor = "#0056b3";
          e.target.style.transform = "scale(1.05)";
        }}
        onMouseOut={(e) => {
          e.target.style.backgroundColor = "#007bff";
          e.target.style.transform = "scale(1)";
        }}
      >
        Về trang chủ
      </Link>
      <Footer />
    </div>
  );
}
