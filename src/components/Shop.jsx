import React, { useState, useEffect } from "react";
import Header from "./Header";
import ProductShop from "../product/ProductShop";
import { useLocation, useNavigate } from "react-router-dom"; // Import these hooks
import Footer from "./Footer";
import { categoryApi } from "../api/categoryApi"; // Import API
import { brandApi } from "../api/brandApi"; // Import API

export default function Shop() {
  const [selectedPrice, setSelectedPrice] = useState(null);
  const location = useLocation(); // Get the current location
  const navigate = useNavigate(); // Get the navigate function
  const [categories, setCategories] = useState([]); // State lưu danh sách danh mục
  const [selectedCategories, setSelectedCategories] = useState([]);

  const [brands, setBrands] = useState([]); // Khai báo state cho danh sách thương hiệu

  useEffect(() => {
    // Gọi API để lấy danh sách thương hiệu khi component được render
    brandApi.getAll().then((response) => {
      setBrands(response.data); // Lưu danh sách thương hiệu vào state
    });
  }, []);

  const handleBrandChange = (brandId) => {
    const queryParams = new URLSearchParams(location.search);
    if (queryParams.get("brand") === brandId) {
      queryParams.delete("brand"); // Bỏ lọc nếu thương hiệu đã được chọn
    } else {
      queryParams.set("brand", brandId); // Thêm thương hiệu vào URL
    }
    navigate({ search: queryParams.toString() });
  };

  const handleCategoryChange = (e, categoryId) => {
    if (e.target.checked) {
      // Chỉ chọn một danh mục
      setSelectedCategories([categoryId]);
    } else {
      // Nếu bỏ chọn, đặt lại danh mục đã chọn thành mảng rỗng
      setSelectedCategories([]);
    }

    // Cập nhật lại URL để phản ánh bộ lọc
    const queryParams = new URLSearchParams(location.search);
    if (categoryId) {
      queryParams.set("categories", categoryId); // Chỉ gửi 1 danh mục đã chọn
    } else {
      queryParams.delete("categories"); // Nếu không chọn gì thì xóa bộ lọc
    }
    queryParams.set("page", 1); // Reset về trang đầu tiên khi thay đổi bộ lọc
    navigate(`/shop?${queryParams.toString()}`);
  };

  const handlePriceChange = (e, priceRange) => {
    const updatedPrice = e.target.checked ? priceRange : null; // Nếu chọn thì lưu giá trị, nếu bỏ chọn thì set null

    setSelectedPrice(updatedPrice); // Cập nhật state

    // Cập nhật lại URL để phản ánh bộ lọc
    const queryParams = new URLSearchParams(location.search);
    if (updatedPrice) {
      queryParams.set("price_range", updatedPrice); // Chỉ gửi giá trị duy nhất, không phải mảng
    } else {
      queryParams.delete("price_range"); // Nếu không chọn giá trị nào, xóa bộ lọc
    }
    queryParams.set("page", 1); // Reset về trang đầu tiên khi thay đổi bộ lọc
    navigate(`/shop?${queryParams.toString()}`);
  };
  useEffect(() => {
    // Gọi API để lấy tất cả danh mục khi component được render
    categoryApi.getAll().then((response) => {
      setCategories(response.data); // Lưu danh mục vào state
    });
  }, []);

  return (
    <div>
      <div>
        {/* Topbar Start */}
        <Header />
        {/* Topbar End */}
        {/* Navbar Start */}
        {/* Navbar End */}
        {/* Breadcrumb Start */}
        <div className="container-fluid">
          <div className="row px-xl-5">
            <div className="col-12">
              <nav className="breadcrumb bg-light mb-30">
                <a className="breadcrumb-item text-dark" href="#">
                  Trang chủ
                </a>
                <a className="breadcrumb-item text-dark" href="#">
                  Cửa hàng
                </a>
              </nav>
            </div>
          </div>
        </div>
        {/* Breadcrumb End */}
        {/* Shop Start */}
        <div className="container-fluid">
          <div className="row px-xl-5">
            {/* Sidebar cửa hàng bắt đầu */}
            <div className="col-lg-3 col-md-4">
              {/* Bộ lọc theo giá bắt đầu */}
              <h5 className="section-title position-relative text-uppercase mb-3">
                <span className="bg-secondary pr-3">Lọc theo giá</span>
              </h5>
              <div className="bg-light p-4 mb-30">
                <form>
                  <div className="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input
                      type="checkbox"
                      className="custom-control-input"
                      id="price-1"
                      onChange={(e) => handlePriceChange(e, "0-100")}
                      checked={selectedPrice === "0-100"} // Kiểm tra nếu giá trị là "0-100"
                    />
                    <label className="custom-control-label" htmlFor="price-1">
                      0₫ - 100.000₫
                    </label>
                  </div>
                  <div className="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input
                      type="checkbox"
                      className="custom-control-input"
                      id="price-2"
                      onChange={(e) => handlePriceChange(e, "100-200")}
                      checked={selectedPrice === "100-200"} // Kiểm tra nếu giá trị là "100-200"
                    />
                    <label className="custom-control-label" htmlFor="price-2">
                      100.000₫ - 200.000₫
                    </label>
                  </div>
                  <div className="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input
                      type="checkbox"
                      className="custom-control-input"
                      id="price-3"
                      onChange={(e) => handlePriceChange(e, "200-400")}
                      checked={selectedPrice === "200-400"}
                    />
                    <label className="custom-control-label" htmlFor="price-3">
                      200.000₫ - 400.000₫
                    </label>
                  </div>
                  <div className="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input
                      type="checkbox"
                      className="custom-control-input"
                      id="price-4"
                      onChange={(e) => handlePriceChange(e, "500+")}
                      checked={selectedPrice === "500+"}
                    />
                    <label className="custom-control-label" htmlFor="price-4">
                      Trên 500.000₫
                    </label>
                  </div>
                </form>
              </div>

              {/* Bộ lọc theo giá kết thúc */}
              {/* Bộ lọc theo màu bắt đầu */}
              <h5 className="section-title position-relative text-uppercase mb-3">
                <span className="bg-secondary pr-3">Lọc theo danh mục</span>
              </h5>
              <div className="bg-light p-4 mb-30">
                <form>
                  {categories.map((category) => (
                    <div
                      className="custom-control custom-radio d-flex align-items-center justify-content-between mb-3"
                      key={category.id}
                    >
                      <input
                        type="radio"
                        className="custom-control-input"
                        id={`category-${category.id}`}
                        name="category" // Tên chung cho các radio button
                        onChange={(e) => handleCategoryChange(e, category.id)}
                        checked={selectedCategories.includes(category.id)} // Kiểm tra nếu danh mục đã được chọn
                      />
                      <label
                        className="custom-control-label"
                        htmlFor={`category-${category.id}`}
                      >
                        {category.name}
                      </label>
                      <span className="badge border font-weight-normal">
                        {category.productCount}
                      </span>
                    </div>
                  ))}
                </form>
              </div>
              {/* Bộ lọc theo màu sắc kết thúc */}
              {/* Bộ lọc theo kích cỡ bắt đầu */}
              <h5 className="section-title position-relative text-uppercase mb-3">
                <span className="bg-secondary pr-3">Lọc theo thương hiệu</span>
              </h5>
              <div className="bg-light p-4 mb-30">
                <form>
                  {brands.map((brand) => (
                    <div
                      key={brand.id}
                      className="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3"
                    >
                      <input
                        type="checkbox"
                        className="custom-control-input"
                        id={`brand-${brand.id}`}
                        onChange={() => handleBrandChange(brand.id)}
                      />
                      <label
                        className="custom-control-label"
                        htmlFor={`brand-${brand.id}`}
                      >
                        {brand.name}
                      </label>
                      <span className="badge border font-weight-normal">
                        {brand.product_count}
                      </span>
                    </div>
                  ))}
                </form>
              </div>

              {/* Bộ lọc theo kích cỡ kết thúc */}
            </div>
            {/* Sidebar cửa hàng kết thúc */}
            {/* Sản phẩm cửa hàng bắt đầu */}
            <div className="col-lg-9 col-md-8">
              <ProductShop />
            </div>
            {/* Sản phẩm cửa hàng kết thúc */}
          </div>
        </div>

        {/* Shop End */}
        {/* Footer Start */}
        <Footer />
        {/* Footer End */}
        {/* Back to Top */}
        <a href="#" className="btn btn-primary back-to-top">
          <i className="fa fa-angle-double-up" />
        </a>
        {/* JavaScript Libraries */}
        {/* Contact Javascript File */}
        {/* Template Javascript */}
      </div>
    </div>
  );
}
