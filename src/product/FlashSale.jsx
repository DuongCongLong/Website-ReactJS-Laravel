import React, { useEffect, useState } from "react";
import { productApi } from "../api/productApi";
import Loading from "../components/Loading"; // Import Loading component
import FlashSaleCart from "./FlashSaleCart";

export default function FlashSale() {
  const [products, setFlashSale] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchFlashSale = async () => {
      try {
        const response = await productApi.getAll();
        const products = Array.isArray(response.data) ? response.data : [];
        setFlashSale(products);
      } catch (error) {
        setError("Lỗi khi tải sản phẩm");
      } finally {
        setLoading(false);
      }
    };

    fetchFlashSale();
  }, []);

  const filteredProducts = products
  .filter((product) => product.discount > 0) // Lọc các sản phẩm có giảm giá
  .slice(0, 4); // Giới hạn chỉ hiển thị tối đa 4 sản phẩm
  return (
    <div>
      <div className="container-fluid pt-5 pb-3">
        <h2 className="section-title position-relative text-uppercase mx-xl-5 mb-4">
          <span className="bg-secondary pr-3">Sản phẩm ưu đãi</span>
        </h2>
        {loading && <Loading />} {/* Hiển thị GIF loading khi đang tải sản phẩm */}
        {error && <p>{error}</p>}
        {!loading && products.length === 0 && <p>Không có sản phẩm nào.</p>}

        {/* Dùng d-flex và flex-wrap để các sản phẩm nằm ngang */}
        <div className="row d-flex flex-wrap justify-content-start">
        {!loading &&
          filteredProducts.map((product) => (
            <div key={product.product_id} className="col-lg-3 col-md-4 col-sm-6 pb-1">
              <FlashSaleCart product={product} />
            </div>
          ))}
      </div>
      </div>
    </div>
  );
}
