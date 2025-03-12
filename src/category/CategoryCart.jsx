import React from "react";
import AppUrl from "../api/AppURL"; // Đảm bảo đường dẫn đến ảnh

export default function CategoryCart({ category }) {
  return (
    <div className="col-lg-3 col-md-4 col-sm-6 pb-1">
      <a className="text-decoration-none" href="shop?categories=7&page=1">
        <div className="cat-item d-flex align-items-center mb-4">
          <div className="overflow-hidden" style={{ width: 100, height: 100 }}>
            <img
              className="img-fluid"
              src={`${AppUrl.ImageUrl}/images/categorys/${category.image}`}
              alt={category.name} // Thêm alt cho ảnh để đảm bảo tính khả dụng
            />
          </div>
          <div className="flex-fill pl-3">
            <h6>{category.name}</h6>
            <small className="text-body">Có {category.productCount} sản phẩm</small> {/* Hiển thị số lượng sản phẩm */}
          </div>
        </div>
      </a>
    </div>
  );
}
