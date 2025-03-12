import React, { useEffect, useState, useContext } from "react";
import { Link, useLocation } from "react-router-dom"; // Import useLocation
import { useNavigate } from "react-router-dom";
import { CartContext } from "../components/CartContext";
import { productApi } from "../api/productApi";
import axios from "axios";
import { brandApi } from "../api/brandApi";
import cartApi from "../api/cartApi";
import { menuApi } from "../api/menuApi";

export default function Header() {
  const { cart, setCart } = useContext(CartContext); // Lấy giỏ hàng từ context
  const [total, setTotal] = useState(0); // Tổng giá trị của giỏ hàng
  // Tính số lượng sản phẩm trong giỏ hàng
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const navigate = useNavigate();
  const [products, setProducts] = useState([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [loading, setLoading] = useState(false);
  const [isSearchVisible, setIsSearchVisible] = useState(true); // State để kiểm soát việc hiển thị tìm kiếm
  const location = useLocation(); // Lấy thông tin đường dẫn hiện tại
  const [suggestions, setSuggestions] = useState([]); // State để lưu gợi ý
  const [brands, setBrands] = useState([]);
  const [selectedBrand, setSelectedBrand] = useState(null); // Khởi tạo với giá trị mặc định là null

  const [menus, setMenus] = useState([]);
  const handleBrandSelect = (brandId) => {
    const queryParams = new URLSearchParams(location.search);
    queryParams.set("brand", brandId); // Lọc theo thương hiệu
    queryParams.set("page", 1); // Reset về trang đầu tiên khi chọn thương hiệu
    console.log(queryParams.toString()); // In ra URL để kiểm tra
    navigate(`/shop?${queryParams.toString()}`);
  };

  useEffect(() => {
    const fetchBanners = async () => {
      try {
        const response = await menuApi.index();
        console.log("log", response.data); // Kiểm tra dữ liệu trả về từ API
        setMenus(response.data);
      } catch (error) {
        console.error("Lỗi khi lấy menu: ", error);
      }
    };
    fetchBanners();
  }, []);

  useEffect(() => {
    const fetchBrands = async () => {
      try {
        const response = await brandApi.getAll(); // Gọi API lấy tất cả các thương hiệu

        setBrands(response.data); // Cập nhật danh sách thương hiệu vào state
      } catch (error) {
        console.error("Lỗi khi lấy danh sách thương hiệu", error);
      }
    };

    fetchBrands();
  }, []); // Chỉ chạy 1 lần khi component mount

  const handleSearch = (e) => {
    e.preventDefault();
    // Thực hiện hành động tìm kiếm ở đây
    console.log("Searching for:", searchTerm);
    navigate(`/shop?search=${searchTerm}`); // Điều hướng đến trang ProductShop với từ khóa
    // Ẩn khung tìm kiếm sau khi nhấn
    setIsSearchVisible(false);
  };

  // Hiển thị lại phần tìm kiếm khi không có dữ liệu trong ô tìm kiếm
  useEffect(() => {
    console.log("isSearchVisible", isSearchVisible); // In ra giá trị của isSearchVisible
    if (searchTerm === "") {
      setIsSearchVisible(true);
    }
  }, [searchTerm]);

  useEffect(() => {
    // Kiểm tra trạng thái đăng nhập khi component được render
    const userLoggedIn = localStorage.getItem("isLoggedIn");
    if (userLoggedIn) {
      setIsLoggedIn(JSON.parse(userLoggedIn)); // Cập nhật trạng thái đăng nhập
    }
  }, []);

  const handleLogout = () => {
    // Xử lý đăng xuất
    localStorage.removeItem("isLoggedIn");
    localStorage.removeItem("token");
    localStorage.removeItem("userName");
    setIsLoggedIn(false);
    localStorage.clear();
    sessionStorage.clear(); // Xóa tất cả dữ liệu trong sessionStorage (nếu có)
    navigate("/"); // Chuyển hướng về trang chủ
  };

  const fetchProducts = async (search = "") => {
    setLoading(true);
    try {
      const response = await productApi.getAllproduct({
        params: { search }, // Gửi từ khóa tìm kiếm
      });
      setProducts(response.data.data); // Gắn dữ liệu sản phẩm
    } catch (error) {
      console.error("Error fetching products:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchProducts(); // Lấy sản phẩm ban đầu
  }, []);
  useEffect(() => {
    // Kiểm tra nếu đang ở trang ProductBox thì ẩn tìm kiếm
    if (location.pathname.includes("shop")) {
      setIsSearchVisible(false); // Ẩn phần tìm kiếm
    }
  }, [location]);

  const fetchSuggestions = async (term) => {
    if (term.length > 2) {
      // Chỉ thực hiện tìm kiếm khi từ khoá có ít nhất 3 ký tự
      try {
        const response = await productApi.getAllproduct({
          params: { search: term }, // Gửi từ khoá tìm kiếm
        });
        const filteredSuggestions = response.data.data.filter((product) =>
          product.product_name.toLowerCase().includes(term.toLowerCase())
        ); // Lọc các sản phẩm phù hợp với từ khoá
        setSuggestions(filteredSuggestions); // Cập nhật danh sách gợi ý
      } catch (error) {
        console.error("Error fetching suggestions:", error);
      }
    } else {
      setSuggestions([]); // Nếu từ khoá quá ngắn, không gợi ý
    }
  };

  const fetchCart = async () => {
    const userId = localStorage.getItem("user_id");
    const token = localStorage.getItem("token");

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

          setCart(validatedCart); // Đảm bảo rằng giỏ hàng được cập nhật đúng

          const calculatedTotal = validatedCart.reduce(
            (acc, item) => acc + item.price * item.quantity,
            0
          );
          setTotal(calculatedTotal); // Cập nhật tổng giá trị giỏ hàng
        } else {
          console.log("Giỏ hàng trống hoặc dữ liệu không hợp lệ");
        }
      } catch (error) {
        console.error(
          "Error fetching cart:",
          error.response ? error.response.data : error.message
        );
      }
    } else {
      console.log("User ID or token not found");
    }
  };

  const totalUniqueItems = new Set(cart.map((item) => item.id)).size; // Tính số lượng sản phẩm unique trong giỏ hàng

  return (
    <div>
      <div className="container-fluid">
        <div className="row bg-secondary py-1 px-xl-5">
          <div className="col-lg-6 d-none d-lg-block">
            <div className="d-inline-flex align-items-center h-100">
              <a className="text-body mr-3" href="/about">
                Giới thiệu
              </a>
              <a href="/contact" className="text-body mr-3">
                Liên hệ
              </a>
              <a className="text-body mr-3" href="/support">
                Hỗ trợ
              </a>
              <a className="text-body mr-3" href="/faq">
                Câu hỏi thường gặp
              </a>
            </div>
          </div>
          <div className="col-lg-6 text-center text-lg-right">
            <div className="d-inline-flex align-items-center">
              <div className="btn-group">
                <button
                  type="button"
                  className="btn btn-sm btn-light dropdown-toggle"
                  data-toggle="dropdown"
                >
                  Tài khoản
                </button>

                {/* Dropdown menu */}
                <div className="dropdown-menu dropdown-menu-right">
                  {/* Tài khoản của tôi nằm trong dropdown */}
                  <a className="dropdown-item" href="/myaccount">
                    Tài khoản của tôi
                  </a>

                  {isLoggedIn ? (
                    <>
                      <button className="dropdown-item" onClick={handleLogout}>
                        Đăng xuất
                      </button>
                      {/* Thêm các mục khác nếu cần */}
                      <Link to="/register" className="dropdown-item">
                        Đăng ký
                      </Link>
                    </>
                  ) : (
                    <Link to="/login" className="dropdown-item">
                      Đăng nhập
                    </Link>
                  )}
                </div>
              </div>
            </div>
            <div className="d-inline-flex align-items-center d-block d-lg-none">
              <a href className="btn px-0 ml-2">
                <i className="fas fa-heart text-dark" />
                <span
                  className="badge text-dark border border-dark rounded-circle"
                  style={{ paddingBottom: 2 }}
                >
                  0
                </span>
              </a>
              <a href className="btn px-0 ml-2">
                <i className="fas fa-shopping-cart text-dark" />
                <span
                  className="badge text-dark border border-dark rounded-circle"
                  style={{ paddingBottom: 2 }}
                >
                  0
                </span>
              </a>
            </div>
          </div>
        </div>
        <div className="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
          <div className="col-lg-4">
            <a href="/" className="text-decoration-none">
              <span className="h1 text-uppercase text-primary bg-dark px-2">
                Multi
              </span>
              <span className="h1 text-uppercase text-dark bg-primary px-2 ml-n1">
                Shop
              </span>
            </a>
          </div>

          <div
            className="col-lg-4 col-6 text-left"
            style={{ position: "relative" }}
          >
            {isSearchVisible && (
              <form onSubmit={handleSearch}>
                <div className="input-group">
                  <input
                    type="text"
                    className="form-control"
                    placeholder="Tìm kiếm sản phẩm"
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                  />
                  <div className="input-group-append">
                    <button
                      type="submit"
                      className="input-group-text bg-transparent text-primary"
                    >
                      <i className="fa fa-search" />
                    </button>
                  </div>
                </div>
                {/* Hiển thị gợi ý tìm kiếm */}
                {suggestions.length > 0 && (
                  <div
                    style={{
                      position: "absolute", // Đặt gợi ý ra ngoài vị trí của ô tìm kiếm
                      top: "100%", // Đảm bảo phần gợi ý xuất hiện ngay dưới ô input
                      left: "0",
                      width: "100%", // Đảm bảo phần gợi ý rộng bằng ô tìm kiếm
                      maxHeight: "200px",
                      overflowY: "auto",
                      backgroundColor: "#fff",
                      boxShadow: "0 2px 5px rgba(0, 0, 0, 0.1)",
                      borderRadius: "5px",
                      zIndex: "1000", // Đảm bảo gợi ý xuất hiện phía trên các thành phần khác
                    }}
                  >
                    <ul
                      className="suggestions-list"
                      style={{
                        listStyleType: "none",
                        padding: 0,
                        margin: 0,
                      }}
                    >
                      {suggestions.map((product) => (
                        <Link
                          key={product.id} // Thêm key cho mỗi liên kết
                          to={`/detail/${product.product_id}`} // Điều hướng đến trang chi tiết sản phẩm
                          style={{
                            textDecoration: "none", // Hủy bỏ gạch chân mặc định của thẻ <a>
                            color: "inherit", // Sử dụng màu chữ mặc định
                          }}
                        >
                          <li
                            key={product.id}
                            style={{
                              padding: "0.5rem",
                              cursor: "pointer",
                              transition: "background-color 0.3s ease",
                            }}
                            onMouseEnter={(e) =>
                              (e.target.style.backgroundColor = "#f0f0f0")
                            }
                            onMouseLeave={(e) =>
                              (e.target.style.backgroundColor = "transparent")
                            }
                          >
                            {product.product_name}
                          </li>
                        </Link>
                      ))}
                    </ul>
                  </div>
                )}
              </form>
            )}
          </div>

          <div className="col-lg-4 col-6 text-right">
            <p className="m-0">Hỗ trợ khách hàng</p>
            <h5 className="m-0">0396813911</h5>
          </div>
        </div>
      </div>
      <div className="container-fluid bg-dark mb-30">
        <div className="row px-xl-5">
          <div className="col-lg-3 d-none d-lg-block">
            <a
              className="btn d-flex align-items-center justify-content-between bg-primary w-100"
              data-toggle="collapse"
              href="#navbar-vertical"
              style={{ height: 65, padding: "0 30px" }}
            >
              <h6 className="text-dark m-0">
                <i className="fa fa-bars mr-2" />
                Danh mục
              </h6>
              <i className="fa fa-angle-down text-dark" />
            </a>
            <nav
              className="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
              id="navbar-vertical"
              style={{ width: "calc(100% - 30px)", zIndex: 999 }}
            >
              <div className="navbar-nav w-100">
                {brands.map((brand) => (
                  <a
                    href=""
                    key={brand.id}
                    className={`nav-item nav-link ${
                      selectedBrand === brand.id ? "active" : ""
                    }`}
                    onClick={() => handleBrandSelect(brand.id)}
                  >
                    {brand.name}
                  </a>
                ))}
              </div>
            </nav>
          </div>
          <div className="col-lg-9">
            <nav className="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
              <a href className="text-decoration-none d-block d-lg-none">
                <span className="h1 text-uppercase text-dark bg-light px-2">
                  Multi
                </span>
                <span className="h1 text-uppercase text-light bg-primary px-2 ml-n1">
                  Shop
                </span>
              </a>
              <button
                type="button"
                className="navbar-toggler"
                data-toggle="collapse"
                data-target="#navbarCollapse"
              >
                <span className="navbar-toggler-icon" />
              </button>
              <div
                className="collapse navbar-collapse justify-content-between"
                id="navbarCollapse"
              >
                <div className="navbar-nav mr-auto py-0">
                  <div className="collapse navbar-collapse" id="navbarNav">
                    <ul className="navbar-nav">
                      {Array.isArray(menus) && menus.length > 0 ? (
                        menus.map((menu, index) => (
                          <li key={index} className="nav-item">
                            <a href={menu.link} className="nav-link">
                              {menu.name}
                              {menu.submenus && (
                                <ul className="submenu">
                                  {menu.submenus.map((submenu, subIndex) => (
                                    <li key={subIndex}>
                                      <a
                                        href={submenu.link}
                                        className="nav-link"
                                      >
                                        {submenu.name}
                                      </a>
                                    </li>
                                  ))}
                                </ul>
                              )}
                            </a>
                          </li>
                        ))
                      ) : (
                        <li className="nav-item">
                          <a href="#" className="nav-link">
                            Loading...
                          </a>
                        </li>
                      )}
                    </ul>
                  </div>
                </div>
                <div className="navbar-nav ml-auto py-0 d-none d-lg-block">
                  <a href="/cart" className="btn px-0 ml-3">
                    <i className="fas fa-shopping-cart text-primary" />
                    <span
                      className="badge text-secondary border border-secondary rounded-circle"
                      style={{
                        display: "inline-block",
                        width: "20px", // Đặt kích thước cụ thể
                        height: "20px",
                        lineHeight: "18px", // Canh giữa nội dung
                        textAlign: "center",
                        paddingBottom: 2,
                      }}
                    >
                      {totalUniqueItems}
                    </span>
                  </a>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  );
}
