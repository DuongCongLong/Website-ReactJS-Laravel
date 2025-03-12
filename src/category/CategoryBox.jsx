import React, { useEffect, useState } from "react";
import { categoryApi } from "../api/categoryApi"; // Import API
import CategoryCart from "./CategoryCart"; // Import CategoryCart component
import Loading from "../components/Loading";

export default function CategoryBox() {
  const [categories, setCategoryBox] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchCategoryBox = async () => {
      try {
        const response = await categoryApi.getAll();
        const categoriesData = Array.isArray(response.data) ? response.data : [];

        // Lấy số lượng sản phẩm cho mỗi danh mục
        const categoriesWithCount = await Promise.all(
          categoriesData.map(async (category) => {
            const countResponse = await categoryApi.getProductCount(category.id);
            category.productCount = countResponse.data.productCount; // Gán số lượng sản phẩm cho mỗi danh mục
            return category;
          })
        );

        setCategoryBox(categoriesWithCount);
      } catch (error) {
        setError("Lỗi khi tải danh mục");
      } finally {
        setLoading(false);
      }
    };

    fetchCategoryBox();
  }, []);

  if (loading) {
    return <div><Loading /></div>; // Hiển thị khi đang tải dữ liệu
  }

  if (error) {
    return <div>{error}</div>; // Hiển thị lỗi nếu có
  }

  return (
    <div className="container-fluid pt-5">
      <h2 className="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span className="bg-secondary pr-3">Danh mục sản phẩm</span>
      </h2>
      <div className="row px-xl-5 pb-3">
        
        {categories.map((category) => (
          <CategoryCart key={category.id} category={category} />
        ))}
      </div>
    </div>
  );
}
