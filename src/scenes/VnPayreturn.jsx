import React, { useEffect, useState } from "react";
import { Link, useLocation } from "react-router-dom";
import orderApi from "../api/orderApi";

export default function VnPayReturn() {
  const location = useLocation();
  const [message, setMessage] = useState(null);

  const vnpayCallback = async (payload) => {
    try {
      await orderApi.completeOrder(payload);
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    const query = new URLSearchParams(location.search);
    const vnp_ResponseCode = query.get("vnp_ResponseCode");
    const vnp_TxnRef = query.get("vnp_TxnRef");
    if (vnp_ResponseCode === "00") {
      if (vnp_TxnRef) {
        vnpayCallback({ vnp_TxnRef, vnp_ResponseCode });
      }
      setMessage("Thanh toán thành công!");
    } else {
      setMessage("Thanh toán thất bại!");
    }
  }, [location]);

  return (
    <div
      style={{
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        flexDirection: "column",
        height: "100vh",
        backgroundColor: "#f4f4f9",
        padding: "0 20px",
      }}
    >
      <div
        style={{
          fontSize: "48px",
          color: "#28a745",
          fontWeight: "bold",
          marginBottom: "20px",
          textAlign: "center",
        }}
      >
        {message}
      </div>
      <div
        style={{
          fontSize: "16px",
          color: "#6c757d",
          marginBottom: "40px",
          textAlign: "center",
        }}
      >
        Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.
      </div>
      <Link
        to="/"
        style={{
          fontSize: "18px",
          fontWeight: "500",
          textDecoration: "none",
          backgroundColor: "#007bff",
          color: "#fff",
          padding: "10px 20px",
          borderRadius: "5px",
          transition: "background-color 0.3s",
        }}
        onMouseOver={(e) => (e.target.style.backgroundColor = "#0056b3")}
        onMouseOut={(e) => (e.target.style.backgroundColor = "#007bff")}
      >
        Về trang chủ
      </Link>
    </div>
  );
}
