import React, { useEffect, useState } from 'react';
import { bannerApi } from '../api/bannerApi';
import AppUrl from "../api/AppURL";
import he from "he";
import Post from './Post';

export default function Banner(banner) {
  const [banners, setBanners] = useState([]);

  // Gọi API để lấy dữ liệu banner
  useEffect(() => {
    const fetchBanners = async () => {
      try {
        const response = await bannerApi.index();
        setBanners(response.data.slice(0, 3));
      } catch (error) {
        console.error("Lỗi khi lấy banner: ", error);
      }
    };
    fetchBanners();
  }, []); // Chỉ gọi API khi component mount

  return (
    <div>
      <div className="container-fluid mb-3">
        <div className="row px-xl-5">
          <div className="col-lg-8">
            <div
              id="header-carousel"
              className="carousel slide carousel-fade mb-30 mb-lg-0"
              data-ride="carousel"
            >
              <ol className="carousel-indicators">
                {banners.map((_, index) => (
                  <li
                    key={index}
                    data-target="#header-carousel"
                    data-slide-to={index}
                    className={index === 0 ? 'active' : ''}
                  />
                ))}
              </ol>
              <div className="carousel-inner">
                {banners.map((banner, index) => (
                  <div
                    key={banner.id}
                    className={`carousel-item ${index === 0 ? 'active' : ''}`}
                    style={{ height: 430, position: "relative" }}
                  >
                    <img
                      className="w-100 h-100"
                      src={`${AppUrl.ImageUrl}/images/banners/${banner.image}`}
                      style={{
                        objectFit: "cover",
                        position: "absolute",
                        left: 0,
                        top: 0,
                      }}
                      alt={banner.name}
                    />
                    <div className="carousel-caption d-flex flex-column align-items-center justify-content-center">
                      <div className="p-3" style={{ maxWidth: 700 }}>
                        <h1 className="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                          {banner.name} {/* Tên banner */}
                        </h1>
                        <p className="mx-md-5 px-5 animate__animated animate__bounceIn">
                        <p dangerouslySetInnerHTML={{ __html: banner.description }} />

                        </p>
                        <a
                          className="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                          href={banner.link} // Link từ dữ liệu banner
                        >
                          Mua Ngay
                        </a>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
          <Post />
        </div>
      </div>
    </div>
  );
}
