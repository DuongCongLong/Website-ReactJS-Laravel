import React, { useEffect, useState, useContext } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import he from "he";
import { ToastContainer  } from "react-toastify";  

import Header from "../components/Header";
import Footer from "../components/Footer";
import { CartContext } from "../components/CartContext";
import AppUrl from "../api/AppURL";
import { productApi } from "../api/productApi";
import CartApiRequest from '../api/cartApi';
import Loading from "../components/Loading"; // Import Loading component

export default function Detail() {
  const { id } = useParams(); // Lấy ID từ URL
  const [product, setProduct] = useState(null); // State lưu thông tin sản phẩm
  const [loading, setLoading] = useState(true); // State để kiểm tra trạng thái đang tải dữ liệu
  const [error, setError] = useState(null); // State lưu lỗi nếu xảy ra trong quá trình gọi API
  const { addToCart } = useContext(CartContext);
  const [quantity, setQuantity] = useState(1);
  const navigate = useNavigate();
  

  // Gọi API để lấy thông tin sản phẩm
  useEffect(() => {
    const fetchProduct = async () => {
      try {
        const response = await productApi.get(id); // Dùng productApi
        setProduct(response.data);
        setLoading(false);
      } catch (err) {
        console.error("Lỗi khi lấy thông tin sản phẩm:", err);
        setError(err);
        setLoading(false);
      }
    };
    fetchProduct();
  }, [id]);

  if (loading) {
    return <div style={{
      position: "fixed", // Đảm bảo vị trí của loading luôn cố định
      top: "0", // Căn lên trên
      left: "0", // Căn sang trái
      width: "100%", // Chiếm toàn bộ chiều rộng
      height: "100%", // Chiếm toàn bộ chiều cao
      display: "flex", // Sử dụng flexbox để căn giữa
      justifyContent: "center", // Căn giữa theo chiều ngang
      alignItems: "center", // Căn giữa theo chiều dọc
      backgroundColor: "rgba(255, 255, 255, 0.7)", // Màu nền mờ để tạo hiệu ứng loading
      zIndex: "9999" // Đảm bảo nó hiển thị trên các thành phần khác
  }}>
          <img
        src={`${AppUrl.ImageFE}/img/Spin123.gif`}
        alt="Loading..."
        width="150"  // Điều chỉnh kích thước theo nhu cầu
        height="150"
      />
  </div>; // Hiển thị thông tin đang tải
  }

  if (error) {
    return <div>Lỗi: Không thể lấy thông tin sản phẩm.</div>;
  }

  const handleIncrease = () => {
    setQuantity((prevQuantity) => {
      console.log('Increasing quantity: ', prevQuantity + 1);
      return prevQuantity + 1;
    });
  };
  
  const handleDecrease = () => {
    setQuantity((prevQuantity) => {
      const newQuantity = prevQuantity > 1 ? prevQuantity - 1 : 1;
      console.log('Decreasing quantity: ', newQuantity);
      return newQuantity;
    });
  };
  
  // Hàm lọc toàn bộ HTML
  const stripHtmlTags = (htmlString) => {
    return htmlString.replace(/<[^>]*>/g, ""); // Regex lọc tất cả thẻ HTML
  };

  const handleAddToCart = async () => {
    const token = localStorage.getItem('token'); // Lấy token từ localStorage
    console.log("Token:", token);

    if (!token) {
      alert('Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng.');
      navigate('/login'); // Điều hướng đến trang đăng nhập nếu chưa đăng nhập
      return;
    }
  
    const newItem = {
      product_id: product?.product_id,
      name: product?.name, // Đảm bảo lấy tên sản phẩm
      price: product?.price, // Đảm bảo lấy giá sản phẩm
      image: product?.image, // Đảm bảo lấy hình ảnh sản phẩm
      quantity: quantity,
      user_id: 5, // Ví dụ: lấy từ thông tin người dùng đăng nhập
      created_by: 1,
      updated_by: 1,
      status: 1,
    };
  
    try {
      const res = await axios.post(
        'http://localhost:8000/api/cart/add',
        newItem,
        {
          headers: {
            Authorization: `Bearer ${token}`, // Gửi token trong header
          },
        }
      );
      addToCart(newItem); // Thêm sản phẩm vào giỏ hàng trong context
      navigate('/cart');
    } catch (error) {
      console.error('Lỗi khi thêm sản phẩm vào giỏ hàng:', error);
      alert('Có lỗi xảy ra. Vui lòng thử lại.');
      console.log("Error details:", error.response ? error.response.data : error);
    }
  };

  return (
    <div>
      <Header />
      <div className="container-fluid pb-5">
        <div className="row px-xl-5">
          <div className="col-lg-5 mb-30">
          <div
  id="product-carousel"
  className="carousel slide"
  data-ride="carousel"
>
  {product?.images && product.images.length > 0 ? (
    product.images.map((image, index) => (
      <div
        className={`carousel-item ${index === 0 ? "active" : ""}`}
        key={index}
      >
        <img
          className="d-block mx-auto"
          style={{
            width: "100%", // Đảm bảo hình ảnh chiếm toàn bộ chiều rộng của khung
            height: "auto", // Đảm bảo tỷ lệ chiều cao của hình ảnh đúng
            objectFit: "cover", // Đảm bảo hình ảnh bao phủ khung mà không bị méo
          }}
          src={`${AppUrl.ImageUrl}/images/products/${image}`}
          alt={product.name || "Product Image"}
        />
      </div>
    ))
  ) : (
    <div className="carousel-item active">
      <img
        className="d-block w-100" // Đảm bảo hình ảnh chiếm toàn bộ chiều rộng
        style={{
          height: "auto", // Đảm bảo tỷ lệ chiều cao của hình ảnh đúng
          objectFit: "cover", // Đảm bảo hình ảnh bao phủ khung mà không bị méo
        }}
        src={`${AppUrl.ImageUrl}/images/products/${product.image}`}
        alt={product.name || "Product Image"}
      />
    </div>
  )}
</div>

          </div>
          <div className="col-lg-7 h-auto mb-30">
            <div className="h-100 bg-light p-30">
              <h3>{product?.product_name || "Tên sản phẩm"}</h3>
              <div className="d-flex mb-3">
                <div className="text-primary mr-2">
                  <small className="fas fa-star" />
                  <small className="fas fa-star" />
                  <small className="fas fa-star" />
                  <small className="fas fa-star-half-alt" />
                  <small className="far fa-star" />
                </div>
                <small className="pt-1">(0 đánh giá)</small>
              </div>
              <h3 className="font-weight-semi-bold mb-4">
                {product?.price
                  ? `${product.price.toLocaleString()} VNĐ`
                  : "Liên hệ"}
              </h3>
              <p className="mb-4">
                {product?.description
                  ? stripHtmlTags(he.decode(product.description))
                  : "Thông tin sản phẩm"}
              </p>

              <div className="d-flex align-items-center mb-4 pt-2">
                <div
                  className="input-group quantity mr-3"
                  style={{ width: 130 }}
                >
                  <div className="input-group-btn">
                    {/* Giảm số lượng */}
                    <button
                      className="btn btn-primary btn-minus"
                      onClick={handleDecrease}
                    >
                      <i className="fa fa-minus" />
                    </button>
                  </div>
                  <input
                    type="text"
                    className="form-control bg-secondary border-0 text-center"
                    value={quantity}
                    readOnly
                  />
                  <div className="input-group-btn">
                    {/* Tăng số lượng */}
                    <button
                      className="btn btn-primary btn-plus"
                      onClick={handleIncrease}
                    >
                      <i className="fa fa-plus" />
                    </button>
                  </div>
                </div>
                <button
                  className="btn btn-primary px-3"
                  onClick={handleAddToCart}
                >
                  <i className="fa fa-shopping-cart mr-1" /> Thêm vào giỏ hàng
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Footer */}
      <Footer />
      <ToastContainer />
    </div>
  );
}
