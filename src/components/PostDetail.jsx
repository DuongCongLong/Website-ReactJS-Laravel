import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom'; // Để lấy tham số từ URL
import { postApi } from '../api/postApi';
import AppUrl from "../api/AppURL";
import Header from './Header';
import Footer from './Footer';

export default function PostDetail() {
  const { id } = useParams(); // Lấy id từ URL
  const [post, setPost] = useState(null); // Dữ liệu bài viết
  const [loading, setLoading] = useState(true); // Trạng thái tải
  
  useEffect(() => {
    const fetchPostDetail = async () => {
      try {
        const response = await postApi.show(id); // Gọi API để lấy bài viết theo ID
        setPost(response.data); // Lưu bài viết vào state
        setLoading(false);
      } catch (error) {
        console.error("Lỗi khi lấy bài viết chi tiết: ", error);
        setLoading(false);
      }
    };

    fetchPostDetail();
  }, [id]); // Chạy lại khi id thay đổi

  // Dùng cleanDescription sau khi chắc chắn post có dữ liệu
  const cleanDescription = post ? post.description.replace(/<h1>/g, '').replace(/<\/h1>/g, '') : '';

  // Các style CSS inline
  const postDetailStyle = {
    textAlign: 'center', // Căn giữa các phần tử trong chi tiết bài viết
    fontFamily: 'Arial, sans-serif', // Đảm bảo không bị lỗi mã hóa chữ
  };

  const postImageStyle = {
    maxWidth: '80%',  // Giới hạn chiều rộng của ảnh
    height: 'auto',   // Tự động điều chỉnh chiều cao
    margin: '0 auto', // Căn giữa ảnh
    display: 'block', // Đảm bảo ảnh là phần tử block
  };

  const postContentStyle = {
    textAlign: 'center', // Căn giữa nội dung bài viết
    marginTop: '20px', // Khoảng cách giữa ảnh và nội dung
    fontSize: '18px', // Cỡ chữ dễ đọc
    lineHeight: '1.6', // Tăng chiều cao dòng để dễ đọc
    maxWidth: '800px', // Giới hạn chiều rộng của đoạn văn
    margin: '0 auto', // Căn giữa đoạn văn
    padding: '0 20px', // Thêm padding để tạo không gian thoáng cho nội dung
  };

  const buttonStyle = {
    marginTop: '20px', // Khoảng cách giữa chi tiết bài viết và nút quay lại
    padding: '10px 20px', // Đảm bảo nút có đủ không gian
    fontSize: '16px', // Cỡ chữ của nút
    borderRadius: '5px', // Bo tròn các góc của nút
    textDecoration: 'none', // Loại bỏ gạch chân của liên kết
  };

  return (
    <div>
      <Header />
      {loading ? (
        <div>Đang tải bài viết...</div>
      ) : (
        post && (
          <div className="post-detail" style={postDetailStyle}>
            {/* Chỉ cần một thẻ <h1> */}
            <h1>{post.title}</h1>
            <div className="post-image">
              <img
                className="img-fluid"
                src={`${AppUrl.ImageUrl}/images/posts/${post.image}`}
                alt={post.title}
                style={postImageStyle}
              />
            </div>
            <div className="post-content" style={postContentStyle}>
              {/* Dùng dangerouslySetInnerHTML để hiển thị nội dung đã mã hóa */}
              <p dangerouslySetInnerHTML={{ __html: cleanDescription }} />
            </div>
            <a href="/" className="btn btn-success" style={buttonStyle}>Quay lại</a>
          </div>
        )
      )}
      <Footer />
    </div>
  );
}
