import React from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";
import ProductBox from "../product/ProductBox";
import FlashSale from "../product/FlashSale";
import CategoryBox from "../category/CategoryBox";
import Banner from "./Banner";

export default function Home() {
  return (
    <div>
      <Header />
      {/* Topbar End */}
      {/* Navbar Start */}
      {/* Navbar End */}
      {/* Carousel Start */}
    <Banner/>
      {/* Carousel End */}
      {/* Featured Start */}
      <div className="container-fluid pt-5">
        <div className="row px-xl-5 pb-3">
          <div className="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div
              className="d-flex align-items-center bg-light mb-4"
              style={{ padding: 30 }}
            >
              <h1 className="fa fa-check text-primary m-0 mr-3" />
              <h5 className="font-weight-semi-bold m-0">Sản Phẩm Chất Lượng</h5>
            </div>
          </div>
          <div className="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div
              className="d-flex align-items-center bg-light mb-4"
              style={{ padding: 30 }}
            >
              <h1 className="fa fa-shipping-fast text-primary m-0 mr-2" />
              <h5 className="font-weight-semi-bold m-0">Vận Chuyển Miễn Phí</h5>
            </div>
          </div>
          <div className="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div
              className="d-flex align-items-center bg-light mb-4"
              style={{ padding: 30 }}
            >
              <h1 className="fas fa-exchange-alt text-primary m-0 mr-3" />
              <h5 className="font-weight-semi-bold m-0">
                Đổi Trả Trong 14 Ngày
              </h5>
            </div>
          </div>
          <div className="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div
              className="d-flex align-items-center bg-light mb-4"
              style={{ padding: 30 }}
            >
              <h1 className="fa fa-phone-volume text-primary m-0 mr-3" />
              <h5 className="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
            </div>
          </div>
        </div>
      </div>

      {/* Featured End */}
      {/* Categories Start */}
      <CategoryBox />
      {/* Categories End */}
      {/* Products Start */}
      <ProductBox />
      <FlashSale />
      {/* Products End */}
      {/* Offer Start */}
     

      {/* Offer End */}
      {/* Vendor Start */}
      <div className="container-fluid py-5">
        <div className="row px-xl-5">
          <div className="col">
            <div className="owl-carousel vendor-carousel">
              <div className="bg-light p-4">
                <img src="img/vendor-1.jpg" alt />
              </div>
              <div className="bg-light p-4">
                <img src="img/vendor-2.jpg" alt />
              </div>
              <div className="bg-light p-4">
                <img src="img/vendor-3.jpg" alt />
              </div>
              <div className="bg-light p-4">
                <img src="img/vendor-4.jpg" alt />
              </div>
              <div className="bg-light p-4">
                <img src="img/vendor-5.jpg" alt />
              </div>
              <div className="bg-light p-4">
                <img src="img/vendor-6.jpg" alt />
              </div>
              <div className="bg-light p-4">
                <img src="img/vendor-7.jpg" alt />
              </div>
              <div className="bg-light p-4">
                <img src="img/vendor-8.jpg" alt />
              </div>
            </div>
          </div>
        </div>
      </div>
      {/* Vendor End */}
      {/* Footer Start */}
      <Footer />
      {/* JavaScript Libraries */}
      {/* Contact Javascript File */}
      {/* Template Javascript */}
    </div>
  );
}
