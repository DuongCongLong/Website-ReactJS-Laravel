import React, { useState, useEffect } from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";
import cartApi from "../api/cartApi";
import AppUrl from "../api/AppURL";
import orderApi from "../api/orderApi";
import Loading from "../components/Loading";
import { Link, useNavigate } from "react-router-dom";
import CartEventEmitter from "../../src/utils/event";
import axios from "axios";

export default function CheckOut() {
  const [cart, setCart] = useState([]);
  const [total, setTotal] = useState(0);
  const [totalQuantity, setTotalQuantity] = useState(0);
  const [country, setCountry] = useState("");
  const [state, setState] = useState("");
  const [zip, setZip] = useState("");
  const [paymentMethod, setPaymentMethod] = useState("1");
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();
  useEffect(() => {
    fetchCart();
  }, []);

  const fetchCart = async () => {
    const userId = localStorage.getItem("user_id");
    const token = localStorage.getItem("token");
    if (!token) {
      alert('Vui lòng đăng nhập trước khi thanh toán.');
      navigate('/login'); // Điều hướng đến trang đăng nhập nếu chưa đăng nhập
      return;
    }

    if (userId && token) {
      try {
        const response = await cartApi.getCartByUserId(userId);
        if (response.data && response.data.cart_items) {
          const fetchedCart = response.data.cart_items;

          const validatedCart = fetchedCart.map((item) => ({
            ...item,
            quantity: item.quantity,
            price: item.product.price,
            name: item.product?.name,
            image: item.product?.image,
          }));

          setCart(validatedCart);
          const calculatedTotal = validatedCart.reduce(
            (acc, item) => acc + item.price * item.quantity,
            0
          );
          setTotal(calculatedTotal);

          const totalQuantity = validatedCart.reduce(
            (acc, item) => acc + item.quantity,
            0
          );
          setTotalQuantity(totalQuantity);
        } else {
          console.log("Giỏ hàng trống hoặc dữ liệu không hợp lệ");
        }
      } catch (error) {
        console.error(
          "Error fetching cart:",
          error.response ? error.response.data : error.message
        );
      } finally {
        setLoading(false);
      }
    } else {
      console.log("User ID or token not found");
      setLoading(false);
    }
  };

  const handleConfirmOrder = async () => {
    const userId = localStorage.getItem("user_id");
    const token = localStorage.getItem("token");

    if (!userId || !token) {
      alert("Bạn phải đăng nhập để thực hiện thanh toán.");
      return;
    }

    if (!paymentMethod) {
      alert("Vui lòng chọn phương thức thanh toán.");
      return;
    }

    if (!country || !state || !zip) {
      alert("Vui lòng điền đầy đủ địa chỉ.");
      return;
    }

    const totalAmount = cart.reduce(
      (acc, item) => acc + item.price * item.quantity,
      0
    );

    const orderData = {
      user_id: Number(userId),
      totalorder: totalAmount,
      address: country + ', ' + state + ', ' + zip,
      shipping_method_id: 1,
      payment_method_id: Number(paymentMethod),
      shipping_status_id: 1,
      username: localStorage.getItem("userName"),
      email: localStorage.getItem("email"),
      created_at: new Date().toISOString(),
      updated_at: new Date().toISOString(),
      created_by: Number(userId),
      updated_by: Number(userId),
      cart_items: cart,
    };

    try {
      const response = await orderApi.checkout(orderData, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      console.log("Dữ liệu trả về từ backend:", response.data);
      console.log("Order data sent to backend:", orderData);

      if (response.data.success) {
        alert("Đơn hàng của bạn đã được thanh toán thành công!");
        navigate("/payment-success", {
          state: { cart, total: totalAmount, totalQuantity },
       });
        setCountry("");
        setState("");
        setZip("");
      } else {
        alert("Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.");
        console.error("Error details:", response.data.error_details);
      }
    } catch (error) {
      console.error("Error during checkout:", error.response ? error.response.data : error.message);
      alert("Có lỗi xảy ra. Vui lòng thử lại.");
    }
  };

  const handleVNPayPayment = async () => {
    const userId = localStorage.getItem("user_id");
    const token = localStorage.getItem("token");

    // Kiểm tra xem dữ liệu có tồn tại trong localStorage không
    if (!userId || !token) {
        alert("Bạn phải đăng nhập để thực hiện thanh toán.");
        return;
    }

    // Kiểm tra xem phương thức thanh toán có được chọn không
    if (!paymentMethod) {
        alert("Vui lòng chọn phương thức thanh toán.");
        return;
    }

    // Kiểm tra thông tin địa chỉ
    if (!country || !state || !zip) {
        alert("Vui lòng điền đầy đủ địa chỉ.");
        return;
    }

    // Tính tổng số tiền đơn hàng từ giỏ hàng
    const totalAmount = cart.reduce(
        (acc, item) => acc + item.price * item.quantity,
        0
    );

    const orderData = {
        user_id: Number(userId),
        totalorder: totalAmount,
        address: `${country}, ${state}, ${zip}`,
        shipping_method_id: 1, // Phương thức giao hàng mặc định
        payment_method_id: Number(paymentMethod),
        shipping_status_id: 1, // Trạng thái vận chuyển mặc định
        username: localStorage.getItem("userName"),
        email: localStorage.getItem("email"),
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString(),
        created_by: Number(userId),
        updated_by: Number(userId),
        cart_items: cart,
    };

    try {
        const response = await axios.post(
            "http://localhost:8000/api/order/vnpay_payment",
            orderData,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );

        if (response.data.code === "00") {
            // Chuyển hướng đến URL thanh toán từ VNPay

            
            window.location.href = response.data.data;
        } else {
            alert("Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.");
        }
    } catch (error) {
        console.error("Lỗi trong quá trình thanh toán:", error.response ? error.response.data : error.message);
        alert("Có lỗi xảy ra. Vui lòng thử lại.");
    }
};

  
 

  return (
    <div>
      <Header />
      <div className="all-title-box">
        <div className="container">
          <div className="row">
            <div className="col-lg-12">
              <h2>Thanh toán</h2>
              <ul className="breadcrumb">
                <li className="breadcrumb-item">
                  <a href="#">Cửa hàng</a>
                </li>
                <li className="breadcrumb-item active">Thanh toán</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      {loading ? (
  <Loading />
) : (
  <div className="cart-box-main">
    <div className="container">
      <div className="row">
        {/* Address Section */}
        <div className="col-sm-12 col-md-4 mb-3">
          <div className="checkout-address">
            <div className="title-left">
              <h3>Địa chỉ thanh toán</h3>
            </div>
            <form className="needs-validation">
              {/* Address Inputs */}
              <div className="mb-3">
                <label htmlFor="country">Quốc gia *</label>
                <input
                  type="text"
                  className="form-control"
                  id="country"
                  value={country}
                  onChange={(e) => setCountry(e.target.value)}
                  required
                />
              </div>
              <div className="mb-3">
                <label htmlFor="state">Tỉnh/Thành phố *</label>
                <input
                  type="text"
                  className="form-control"
                  id="state"
                  value={state}
                  onChange={(e) => setState(e.target.value)}
                  required
                />
              </div>
              <div className="mb-3">
                <label htmlFor="zip">Mã bưu điện *</label>
                <input
                  type="text"
                  className="form-control"
                  id="zip"
                  value={zip}
                  onChange={(e) => setZip(e.target.value)}
                  required
                />
              </div>
            </form>
          </div>
        </div>

        {/* Order Details Section */}
        <div className="col-sm-12 col-md-8 mb-3">
          <div className="checkout-order">
            <div className="title-left">
              <h3>Đơn hàng của tôi</h3>
            </div>

            {/* Kiểm tra giỏ hàng có sản phẩm không */}
            {cart.length === 0 ? (
              <div className="row">
                <div className="col-md-12">
                  <p>Không có sản phẩm trong giỏ hàng.</p>
                </div>
              </div>
            ) : (
              <>
                {/* Tiêu đề sản phẩm, số lượng, giá và tổng */}
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
                  <div
                    key={index}
                    className="row border-bottom align-items-center"
                  >
                    <div className="col-md-2 d-flex align-items-center ml-5">
                      <div className="product-item d-flex align-items-center justify-content-center">
                        <img
                          src={`${AppUrl.ImageUrl}/images/products/${item.image}`}
                          alt={item.name}
                          style={{
                            width: "50px",
                            height: "50px",
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
                      <p className="text">
                        {item.price.toLocaleString()} VNĐ
                      </p>
                    </div>
                    <div className="col-md-3">
                      <p className="text" style={{ fontWeight: "bold" }}>
                        {(item.price * item.quantity).toLocaleString()} VNĐ
                      </p>
                    </div>
                  </div>
                ))}

                {/* Tổng số lượng sản phẩm */}
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
              </>
            )}

            {/* Phương thức thanh toán */}
            {cart.length > 0 && (
              <>
                <div className="title mt-3 border-top">
                  <span style={{ fontWeight: "bold", fontSize: "18px" }}>
                    Phương thức thanh toán
                  </span>
                </div>
                <div className="my-3 d-flex justify-content-between">
                  <div className="custom-control custom-radio">
                    <input
                      id="payment"
                      name="paymentMethod"
                      type="radio"
                      className="custom-control-input"
                      value="1"
                      checked={paymentMethod === "1"}
                      onChange={(e) => setPaymentMethod(e.target.value)}
                      required
                    />
                    <label className="custom-control-label" htmlFor="payment">
                      Thanh toán nhận hàng
                    </label>
                  </div>
                  <div className="custom-control custom-radio">
                    <input
                      id="vnpay"
                      name="paymentMethod"
                      type="radio"
                      className="custom-control-input"
                      value="4"
                      checked={paymentMethod === "4"}
                      onChange={(e) => setPaymentMethod(e.target.value)}
                    />
                    <label className="custom-control-label" htmlFor="vnpay">
                      Vnpay
                    </label>
                  </div>
                </div>
                {/* Xử lý thanh toán khi nhận hàng */}
                {paymentMethod === "1" && (
                  <div className="mt-3">
                    <button
                      className="btn btn-primary"
                      onClick={handleConfirmOrder}
                    >
                      Xác nhận thanh toán khi nhận hàng
                    </button>
                  </div>
                )}

                {/* Thanh toán PayPal */}
                {/* Thanh toán VNPay */}
                {paymentMethod === "4" && (
                  <div className="mt-3">
                    <button
                      className="btn btn-primary"
                      onClick={handleVNPayPayment}
                    >
                      Thanh toán qua VNPay
                    </button>
                  </div>
                )}
              </>
            )}
          </div>
        </div>
      </div>
    </div>
  </div>
)}


      <Footer />
    </div>
  );
}
