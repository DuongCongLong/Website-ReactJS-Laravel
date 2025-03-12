import React, { useEffect, useState } from "react";
import ProductCart from "./ProductCart";
import { productApi } from "../api/productApi";
import Loading from "../components/Loading"; // Import Loading component

export default function ProductBox() {
  const [products, setProductBox] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProductBox = async () => {
      try {
        const response = await productApi.getAll();
        const products = Array.isArray(response.data) ? response.data : [];
        const sortedProducts = products.sort((a, b) => {
          const dateA = new Date(a.created_at);
          const dateB = new Date(b.created_at);
          return dateB - dateA; // Sắp xếp giảm dần (mới nhất lên đầu)
        });
        setProductBox(sortedProducts);
      } catch (error) {
        setError("Lỗi khi tải sản phẩm");
      } finally {
        setLoading(false);
      }
    };

    fetchProductBox();
  }, []);

  return (
    <div>
      <div className="container-fluid pt-5 pb-3">
        <h2 className="section-title position-relative text-uppercase mx-xl-5 mb-4">
          <span className="bg-secondary pr-3">Sản phẩm nổi bật</span>
        </h2>
        {loading && <Loading />} {/* Hiển thị GIF loading khi đang tải sản phẩm */}
        {error && <p>{error}</p>}
        {!loading && products.length === 0 && <p>Không có sản phẩm nào.</p>}

        {/* Dùng d-flex và flex-wrap để các sản phẩm nằm ngang */}
         <div className="row d-flex flex-wrap justify-content-start">
          {!loading &&
            products
              .slice(0, 4) // Lấy 8 sản phẩm đầu tiên
              .map((product) => (
                <div key={product.product_id} className="col-lg-3 col-md-4 col-sm-6 pb-1">
                  <ProductCart product={product} />
                </div>
              ))}
        </div>

      </div>
    </div>
  );
}
