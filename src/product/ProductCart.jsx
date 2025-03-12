import React from "react";
import AppUrl from ".././api/AppURL";
import { Link } from "react-router-dom";

export default function ProductCart({ product }) {
  // Hàm định dạng tiền tệ Việt Nam
  const formatToVietnameseCurrency = (price) => {
    return price.toLocaleString("vi-VN") + "₫";
  };

  return (
    <div>
      <div className="product-item bg-light mb-2">
        {/* Product Image Section */}
        <div className="product-img position-relative overflow-hidden">
          <img
            className="img-fluid w-100"
            style={{ width: "100%", maxWidth: "150px", height: "200px" }}
            src={`${AppUrl.ImageUrl}/images/products/${product.image}`}
            alt={product.name}
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

        {/* Product Info Section */}
        <div className="text-center py-4">
          <a
            href={`/detail/${product.id}`}
            className="h6 text-decoration-none text-truncate"
          >
            {product.name}
          </a>

          {/* Hiển thị giá sau khi giảm và giá gốc hiển thị bằng VNĐ */}
          <a className="mt-2" href={`/detail/${product.product_id}`}>
  {/* Hiển thị giá sau khi giảm */}
  <h5>
    {(product.price * (1 - product.discount / 100)).toLocaleString("vi-VN", {
      style: "currency",
      currency: "VND",
    })}
  </h5>

  {/* Hiển thị giá gốc */}
  <h6 className="text-muted ml-2">
    <del>
      {product.price.toLocaleString("vi-VN", {
        style: "currency",
        currency: "VND",
      })}
    </del>
  </h6>
</a>


          <div className="d-flex align-items-center justify-content-center mb-1">
            {/* Hiển thị đánh giá sao */}
            {[...Array(5)].map((_, index) => (
              <small
                key={index}
                className={`fa fa-star text-primary mr-1 ${
                  index < Math.min(Math.floor(product.rating), 5)
                    ? ""
                    : "text-muted"
                }`}
              />
            ))}
            <small>({product.product_stock})</small>
          </div>
        </div>
      </div>
    </div>
  );
}
