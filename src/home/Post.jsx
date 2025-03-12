import React, { useEffect, useState } from 'react';
import { postApi } from '../api/postApi';
import AppUrl from "../api/AppURL";

export default function Post() {
  const [posts, setPosts] = useState([]); // Dữ liệu bài viết
  const [loading, setLoading] = useState(true); // Biến để theo dõi quá trình tải

  // Gọi API để lấy bài viết khi component được mount
  useEffect(() => {
    const fetchPosts = async () => {
      try {
        const response = await postApi.index(); // Gọi API
        setPosts(response.data); // Lưu dữ liệu bài viết vào state
        setLoading(false); // Đặt trạng thái loading thành false sau khi tải xong
      } catch (error) {
        console.error("Lỗi khi lấy bài viết: ", error);
        setLoading(false);
      }
    };

    fetchPosts();
  }, []); // useEffect chạy chỉ một lần khi component mount

  return (
    <div className="col-lg-4">
      {loading ? (
        <div>Đang tải bài viết...</div>
      ) : (
        posts.map((post) => (
          <div key={post.id} className="product-offer position-relative overflow-hidden mb-30" style={{ height: 200 }}>
            <img
              className="img-fluid"
               src={`${AppUrl.ImageUrl}/images/posts/${post.image}`}
              alt={post.title}
              style={{
                width: "450px",
                height: "200px",
                objectFit: "cover",
                display: "block",
              }}
            />
            <div
              className="offer-text position-absolute top-50 start-50 translate-middle text-center"
              style={{
                background: "rgba(0, 0, 0, 0.5)",
                padding: "10px 20px",
                borderRadius: "8px",
              }}
            >
              <h3 className="text-white mb-3">{post.title}</h3>
              <a href={`/post/${post.post_id}`} className="btn btn-primary">
                Xem ngay
              </a>
            </div>
          </div>
        ))
      )}
    </div>
  );
}
