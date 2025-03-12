import React, { useEffect, useState } from "react";
import { productApi } from "../api/productApi";
import { brandApi } from "../api/brandApi"; // Thêm import API thương hiệu
import Loading from "../components/Loading";
import AppUrl from "../api/AppURL";
import { Link, useNavigate, useLocation } from "react-router-dom";

export default function ProductShop() {
  const [products, setProducts] = useState([]);
  const [brands, setBrands] = useState([]); // State lưu danh sách thương hiệu
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);
  const [totalProducts, setTotalProducts] = useState(0);
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedBrand, setSelectedBrand] = useState(""); // State lưu thương hiệu đã chọn
  const [selectedPrice, setSelectedPrice] = useState(""); // State lưu dải giá đã chọn

  const productsPerPage = 6;
  const navigate = useNavigate();
  const location = useLocation();

  // Gọi API danh sách thương hiệu khi component load
  useEffect(() => {
    const fetchBrands = async () => {
      try {
        const response = await brandApi.getAll();
        if (response && response.data) {
          setBrands(response.data); // Lưu danh sách thương hiệu vào state
        }
      } catch (error) {
        setError("Lỗi khi tải danh sách thương hiệu");
        console.error("Error fetching brands:", error);
      }
    };

    fetchBrands();
  }, []);

  // Gọi API khi URL hoặc từ khóa tìm kiếm thay đổi
  useEffect(() => {
    const queryParams = new URLSearchParams(location.search);
    const page = queryParams.get("page") || 1;
    const search = queryParams.get("search") || "";
    const brand = queryParams.get("brand") || "";
    const priceRange = queryParams.get("price_range") || "";
    const category = queryParams.get("categories") || "";

    setCurrentPage(Number(page));
    setSearchTerm(search);
    setSelectedBrand(brand);
    setSelectedPrice(priceRange);

    const fetchProductBox = async () => {
      try {
        setLoading(true);
        const response = await productApi.getAllproduct({
          page: Number(page),
          limit: productsPerPage,
          search,
          brand,
          price_range: priceRange ? [priceRange] : [], // Gửi bộ lọc giá lên backend
          category, // Thêm tham số category vào API
        });

        if (response && response.data) {
          setProducts(response.data.data);
          setTotalPages(response.data.last_page);
          setTotalProducts(response.data.total);
        } else {
          setError("Dữ liệu không hợp lệ");
        }
      } catch (error) {
        setError("Lỗi khi tải sản phẩm");
        console.error("Error fetching products:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchProductBox();
  }, [location.search]); // Chạy lại khi URL thay đổi

  // Hàm xử lý thay đổi trang
  const handlePageChange = (page) => {
    if (page > 0 && page <= totalPages) {
      const queryParams = new URLSearchParams(location.search);
      queryParams.set("page", page);
      navigate(`/shop?${queryParams.toString()}`);
    }
  };

  // Hàm xử lý tìm kiếm
  const handleSearch = (e) => {
    e.preventDefault();
    const queryParams = new URLSearchParams(location.search);
    queryParams.set("search", searchTerm);
    queryParams.set("page", 1); // Reset về trang đầu tiên khi tìm kiếm
    navigate(`/shop?${queryParams.toString()}`);
  };

  // Hàm xử lý chọn thương hiệu
  const handleBrandSelect = (brandId) => {
    const queryParams = new URLSearchParams(location.search);
    queryParams.set("brand", brandId); // Lọc theo thương hiệu
    queryParams.set("page", 1); // Reset về trang đầu tiên khi chọn thương hiệu
    navigate(`/shop?${queryParams.toString()}`);
  };

  // Hàm xử lý chọn dải giá
  const handlePriceSelect = (priceRange) => {
    const queryParams = new URLSearchParams(location.search);
    queryParams.set("price_range", priceRange); // Lọc theo dải giá
    queryParams.set("page", 1); // Reset về trang đầu tiên khi chọn dải giá
    navigate(`/shop?${queryParams.toString()}`);
  };

  if (loading) {
    return <Loading />;
  }

  if (error) {
    return <div>{error}</div>;
  }

  // Kiểm tra nếu không có sản phẩm nào
  if (products.length === 0) {
    return (
      <div>
        Sản phẩm hiện tại không có. Bạn có thể thử tìm kiếm với từ khóa khác
        hoặc
        <Link to="/shop" className="btn btn-primary ml-2">
          Xem tất cả sản phẩm
        </Link>
      </div>
    );
  }

  return (
    <div>
      {/* Form tìm kiếm */}
      <form onSubmit={handleSearch} className="mb-3">
        <div className="input-group">
          <input
            type="text"
            className="form-control"
            placeholder="Tìm kiếm sản phẩm"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
          <div className="input-group-append">
            <button type="submit" className="btn btn-primary">
              <i className="fa fa-search" />
            </button>
          </div>
        </div>
      </form>

      {/* Danh sách thương hiệu */}
      <nav
        className="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
        id="navbar-vertical"
        style={{ width: "calc(100% - 30px)", zIndex: 999 }}
      >
        <div className="navbar-nav w-100">
          {/* Hiển thị danh sách thương hiệu */}
          {brands.map((brand) => (
            <a
              href="#"
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

      {/* Danh sách sản phẩm */}
      <div className="row pb-3">
        {products.map((product) => (
          <div
            className="col-lg-4 col-md-6 col-sm-6 pb-1"
            key={product.product_id}
          >
            <div className="product-item bg-light mb-4">
              <div className="product-img position-relative overflow-hidden">
                <img
                  className="img-fluid w-100"
                  src={`${AppUrl.ImageUrl}/images/products/${product.image}`}
                  alt={product.name}
                  style={{
                    maxHeight: "400px",
                    height: "600px",
                    objectFit: "cover",
                  }}
                />
                <div className="product-action">
                  <Link
                    to={`/detail/${product.product_id}`}
                    className="btn btn-outline-dark btn-square"
                  >
                    <i className="fa fa-shopping-cart" />
                  </Link>
                </div>
              </div>
              <div className="text-center py-4">
                <a
                  className="h6 text-decoration-none"
                  href={`/detail/${product.product_id}`}
                  style={{
                    display: "block", // Đảm bảo thẻ <a> chiếm toàn bộ chiều rộng
                    whiteSpace: "nowrap", // Không cho phép xuống dòng
                    overflow: "hidden", // Ẩn phần nội dung bị tràn
                    textOverflow: "ellipsis", // Thêm dấu ba chấm khi nội dung tràn
                    maxWidth: "100%", // Đảm bảo không vượt quá chiều rộng của phần tử cha
                    paddingLeft: "30px", // Khoảng cách bên trái
                    paddingRight: "30px",
                  }}
                >
                  {product.product_name}
                </a>

                <div className="d-flex align-items-center justify-content-center mt-2">
                  <h5>
                    {(
                      product.price *
                      (1 - product.discount / 100)
                    ).toLocaleString("vi-VN", {
                      style: "currency",
                      currency: "VND",
                    })}
                  </h5>
                  {product.originalPrice && (
                    <h6 className="text-muted ml-2">
                      <del>{product.originalPrice}₫</del>
                    </h6>
                  )}
                </div>
                <div className="d-flex align-items-center justify-content-center mb-1">
                  {Array.from({ length: 5 }, (_, index) => (
                    <small
                      key={index}
                      className={`fa fa-star${
                        index < product.rating ? " text-primary" : "-half-alt"
                      } mr-1`}
                    />
                  ))}
                  <small>({product.product_stock})</small>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Phân trang */}
      <div className="col-12">
        <nav>
          <ul className="pagination justify-content-center">
            <li className={`page-item ${currentPage === 1 ? "disabled" : ""}`}>
              <button
                className="page-link"
                onClick={() => handlePageChange(currentPage - 1)}
              >
                Trước
              </button>
            </li>
            {[...Array(totalPages)].map((_, index) => (
              <li
                className={`page-item ${
                  currentPage === index + 1 ? "active" : ""
                }`}
                key={index}
              >
                <button
                  className="page-link"
                  onClick={() => handlePageChange(index + 1)}
                >
                  {index + 1}
                </button>
              </li>
            ))}
            <li
              className={`page-item ${
                currentPage === totalPages ? "disabled" : ""
              }`}
            >
              <button
                className="page-link"
                onClick={() => handlePageChange(currentPage + 1)}
              >
                Sau
              </button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  );
}
