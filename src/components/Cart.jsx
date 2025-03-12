import React, { useContext, useEffect, useState } from "react";
import Header from "./Header";
import Footer from "./Footer";
import { CartContext } from "../components/CartContext";
import AppUrl from "../api/AppURL";
import { useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";
import cartApi from '../api/cartApi';
import Loading from "./Loading";

export default function Cart() {
  // Lấy thông tin giỏ hàng từ CartContext
  const { cart, setCart } = useContext(CartContext);
  const navigate = useNavigate(); // Dùng để điều hướng giữa các trang
  const [total, setTotal] = useState(0);
  const [isLoading, setIsLoading] = useState(true); // Khai báo isLoading
  const isCartDrawerVisible = useSelector(
    (state) => state.cart.isCartDrawerVisible
  );

  // Hàm để lấy giỏ hàng của người dùng từ API
  const fetchCart = async () => {
    const userId = localStorage.getItem("user_id");
    const token = localStorage.getItem("token");
    
    if (!token) {
      alert('Vui lòng đăng nhập trước khi xem giỏ hàng.');
      navigate('/login'); // Điều hướng đến trang đăng nhập nếu chưa đăng nhập
      return;
    }
  
    if (userId && token) {
      try {
        setIsLoading(true); // Bắt đầu loading khi lấy dữ liệu
        const response = await cartApi.getCartByUserId(userId);
        if (response.data && response.data.cart_items) {
          const fetchedCart = response.data.cart_items;
  
          const validatedCart = fetchedCart.map(item => ({
            ...item,
            quantity: item.quantity,
            price: item.product.price,
            name: item.product?.name,
            image: item.product?.image, 
          }));
  
          setCart(validatedCart);
  
          const calculatedTotal = validatedCart.reduce(
            (acc, item) => acc + (item.price * item.quantity),
            0
          );
          setTotal(calculatedTotal);
        } else {
          console.log('Giỏ hàng trống hoặc dữ liệu không hợp lệ');
        }
      } catch (error) {
        console.error("Error fetching cart:", error.response ? error.response.data : error.message);
      } finally {
        setIsLoading(false); // Kết thúc loading khi đã lấy xong dữ liệu
      }
    } else {
      console.log("User ID or token not found");
      setIsLoading(false); // Nếu không có ID hoặc token, kết thúc loading
    }
  };
  

  // Tính tổng số lượng và tổng giá của giỏ hàng
  const calculateTotals = () => {
    const subtotal = cart.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
    const shipping = 0; // Phí giao hàng cố định
    const total = subtotal + shipping;
    return { subtotal, shipping, total };
  };

  // Chức năng điều hướng đến trang thanh toán
  const handleProceedToCheckout = () => {
    navigate('/checkout');
  };

  // Thêm chức năng tăng số lượng sản phẩm trong giỏ hàng
  const handleIncreaseQuantity = async (id) => {
    const updatedCart = cart.map((item) =>
      item.id === id ? { ...item, quantity: item.quantity + 1 } : item
    );
    setCart(updatedCart); // Cập nhật giỏ hàng ngay trên giao diện
  
    const userId = localStorage.getItem("user_id");
    const token = localStorage.getItem("token");
  
    if (userId && token) {
      try {
        // Tìm sản phẩm trong giỏ hàng để lấy product_id đúng
        const updatedProduct = updatedCart.find((item) => item.id === id);
        const payload = {
          user_id: userId,
          product_id: updatedProduct.product_id,  // product_id
          quantity: updatedProduct.quantity,       // Gửi số lượng cập nhật
        };
        console.log("Payload sent to server:", payload); // Log payload
        await cartApi.updateCart(payload, token);
      } catch (error) {
        console.error("Error updating cart:", error.response ? error.response.data : error.message);
      }
    } else {
      console.log("User ID or token not found");
    }
  };
  
  
  
  

  // Thêm chức năng giảm số lượng sản phẩm trong giỏ hàng
 // Thêm chức năng giảm số lượng sản phẩm trong giỏ hàng
const handleDecreaseQuantity = async (id) => {
  const updatedCart = cart.map((item) =>
    item.id === id && item.quantity > 1
      ? { ...item, quantity: item.quantity - 1 }
      : item
  );
  setCart(updatedCart); // Cập nhật giỏ hàng ngay trên giao diện

  const userId = localStorage.getItem("user_id");
  const token = localStorage.getItem("token");

  if (userId && token) {
    try {
      // Tìm sản phẩm trong giỏ hàng để lấy product_id đúng
      const updatedProduct = updatedCart.find((item) => item.id === id);
      const payload = {
        user_id: userId,
        product_id: updatedProduct.product_id, // product_id
        quantity: updatedProduct.quantity,      // Gửi số lượng cập nhật
      };
      console.log("Payload sent to server:", payload); // Log payload
      await cartApi.updateCart(payload, token);
    } catch (error) {
      console.error("Error updating cart:", error.response ? error.response.data : error.message);
    }
  } else {
    console.log("User ID or token not found");
  }
};


  const handleRemoveItem = async (id) => {
    const userId = localStorage.getItem("user_id");
    const token = localStorage.getItem("token");
    if (userId && token) {
      try {
        // Gọi API để xóa sản phẩm
        await cartApi.removeCartItem({ user_id: userId, product_id: id });
  
        // Cập nhật giỏ hàng ngay lập tức sau khi xóa sản phẩm
        const updatedCart = cart.filter(item => item.id !== id);
        setCart(updatedCart); // Cập nhật giỏ hàng trên giao diện
  
        // Tính lại tổng sau khi xóa sản phẩm
        const calculatedTotal = updatedCart.reduce(
          (acc, item) => acc + (item.price * item.quantity),
          0
        );
        setTotal(calculatedTotal); // Cập nhật tổng giỏ hàng
      } catch (error) {
        console.error("Error removing item:", error.response ? error.response.data : error.message);
      }
    } else {
      console.log("User ID or token not found");
    }
  };
  


  // useEffect để lấy giỏ hàng khi component được render lần đầu
  useEffect(() => {
    fetchCart(); // Gọi hàm lấy giỏ hàng khi component được render lần đầu
  }, []);

  return (
    <div>
      {/* Hiện Header ở đầu trang */}
      <Header />
      <div className="container-fluid">
        <div className="row px-xl-5">
          <div className="col-lg-8 table-responsive mb-5">
            <table className="table table-light table-borderless table-hover text-center mb-0">
              <thead className="thead-dark">
                <tr>
                  <th>Sản phẩm</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Tổng</th>
                  <th>Xoá</th>
                </tr>
              </thead>
              <tbody className="align-middle">
                {cart.length === 0 ? (
                  <tr>
                  <td colSpan={5} className="text-center">
                    {isLoading ? (
                      <Loading />
                    ) : (
                      <p>Không có sản phẩm trong giỏ hàng</p>
                    )}
                  </td>
                </tr>
                ) : (
                  cart.map((item) => (
                    <tr key={item.id}>
                      <td className="align-middle">
                        <img
                          src={`${AppUrl.ImageUrl}/images/products/${item.image}`}
                          alt={item.name}
                          style={{ width: 50 }}
                        />{" "}
                        {item.name}
                      </td>
                      <td className="align-middle">${item.price}</td>
                      <td className="align-middle">
                        <div
                          className="input-group quantity mx-auto"
                          style={{ width: 100 }}
                        >
                          <div className="input-group-btn">
                            <button
                              className="btn btn-sm btn-primary btn-minus"
                              onClick={() => handleDecreaseQuantity(item.id)}
                            >
                              <i className="fa fa-minus" />
                            </button>
                          </div>
                          <input
                            type="text"
                            className="form-control form-control-sm bg-secondary border-0 text-center"
                            value={item.quantity}
                            readOnly
                          />
                          <div className="input-group-btn">
                            <button
                              className="btn btn-sm btn-primary btn-plus"
                              onClick={() => handleIncreaseQuantity(item.id)}
                            >
                              <i className="fa fa-plus" />
                            </button>
                          </div>
                        </div>
                      </td>
                      <td className="align-middle">
                        ${item.price * item.quantity}
                      </td>
                      <td className="align-middle">
                        <button
                          className="btn btn-sm btn-danger"
                          onClick={() => handleRemoveItem(item.id)}
                        >
                          <i className="fa fa-times" />
                        </button>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
          <div className="col-lg-4">
            <h5 className="section-title position-relative text-uppercase mb-3">
              <span className="bg-secondary pr-3">Tóm tắt giỏ hàng</span>
            </h5>
            <div className="bg-light p-30 mb-5">
              <div className="border-bottom pb-2">
                <div className="d-flex justify-content-between mb-3">
                  <h6>Tổng tạm tính</h6>
                  <h6>${calculateTotals().subtotal}</h6>
                </div>
                <div className="d-flex justify-content-between mb-3">
                  <h6>Phí vận chuyển:</h6>
                  <h6>Miễn phí</h6>
                </div>
              </div>
              <div className="pt-2">
                <div className="d-flex justify-content-between mt-2">
                  <h5>Tổng cộng</h5>
                  <h5>${calculateTotals().total}</h5>
                </div>
                <button
                  onClick={handleProceedToCheckout}
                  className="btn btn-block btn-primary font-weight-bold my-3 py-3"
                >
                  Tiến hành thanh toán
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      {/* Hiện Footer ở cuối trang */}
      <Footer />
    </div>
  );
}
