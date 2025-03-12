import React from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";

export default function About() {
  return (
    <div>
      <div>
        <Header />
        {/* Start All Title Box */}
        <div className="all-title-box">
          <div className="container">
            <div className="row">
              <div className="col-lg-12">
                <h2>Giới thiệu</h2>
                <ul className="breadcrumb">
                  <li className="breadcrumb-item">
                    <a href="/">Trang chủ</a>
                  </li>
                  <li className="breadcrumb-item active">Giới thiệu</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        {/* End All Title Box */}
        {/* Start About Page  */}
        <div className="about-box-main">
          <div className="container">
            <div className="row">
              <div className="col-lg-6">
                <h2 className="noo-sh-title">
                  Chúng tôi là <span>MULTISHOP</span>
                </h2>
                <p>
                  "Chúng tôi luôn nỗ lực để mang đến cho bạn trải nghiệm mua sắm
                  hoàn hảo nhất. Mọi sản phẩm của chúng tôi đều được lựa chọn
                  cẩn thận và được thiết kế với sự tinh tế cao, nhằm mang lại
                  cho bạn sự thoải mái và phong cách. Chúng tôi không ngừng cải
                  thiện để mang đến cho khách hàng những sản phẩm chất lượng
                  nhất, đồng thời đảm bảo giá cả hợp lý. Sự hài lòng của bạn là
                  mục tiêu hàng đầu của chúng tôi, và chúng tôi cam kết mang đến
                  cho bạn những trải nghiệm tuyệt vời nhất khi mua sắm tại cửa
                  hàng của chúng tôi. Hãy để chúng tôi giúp bạn tỏa sáng với
                  những bộ trang phục thời thượng và phong cách nhất."
                </p>
                <p>
                  Chúng tôi tự hào mang đến cho bạn những sản phẩm chất lượng
                  cao, được chăm chút tỉ mỉ từ khâu thiết kế đến sản xuất. Từng
                  chi tiết đều được đầu tư kỹ lưỡng để đảm bảo sự thoải mái và
                  thời trang, giúp bạn luôn tự tin và nổi bật. Chúng tôi cam kết
                  mang lại cho bạn trải nghiệm mua sắm dễ dàng và thuận tiện,
                  với những dịch vụ chăm sóc khách hàng chu đáo nhất.
                </p>
              </div>
              <div className="col-lg-6">
                <div className="banner-frame">
                  {" "}
                  <img
                    className="img-thumbnail img-fluid"
                    src="images/about-img.jpg"
                    alt
                  />
                </div>
              </div>
            </div>

            <div
              className="row my-5"
              style={{
                display: "flex",
                justifyContent: "space-between",
                alignItems: "stretch",
              }}
            >
              <div className="col-sm-6 col-lg-4">
                <div
                  className="service-block-inner text-center"
                  style={{
                    display: "flex",
                    flexDirection: "column",
                    justifyContent: "center",
                    textAlign: "center",
                  }}
                >
                  <h3>Chúng tôi đáng tin cậy.</h3>
                  <p>
                    Chúng tôi cam kết mang đến cho bạn những sản phẩm thời trang
                    chất lượng, kết hợp giữa phong cách hiện đại và sự thoải
                    mái, phù hợp với mọi nhu cầu của bạn. Mỗi sản phẩm đều được
                    thiết kế tỉ mỉ để đáp ứng yêu cầu cao nhất, giúp bạn luôn tự
                    tin và nổi bật.
                  </p>
                </div>
              </div>
              <div className="col-sm-6 col-lg-4">
                <div
                  className="service-block-inner text-center"
                  style={{
                    display: "flex",
                    flexDirection: "column",
                    justifyContent: "center",
                    textAlign: "center",
                  }}
                >
                  <h3>Chúng tôi chuyên nghiệp.</h3>
                  <p>
                    Chúng tôi luôn nỗ lực không ngừng để mang đến cho bạn những
                    sản phẩm chất lượng cao, kết hợp giữa phong cách và sự thoải
                    mái. Mỗi chi tiết đều được chăm chút tỉ mỉ để đảm bảo trải
                    nghiệm tốt nhất cho khách hàng.
                  </p>
                </div>
              </div>
              <div className="col-sm-6 col-lg-4">
                <div
                  className="service-block-inner text-center"
                  style={{
                    display: "flex",
                    flexDirection: "column",
                    justifyContent: "center",
                    textAlign: "center",
                  }}
                >
                  <h3>Chúng tôi là chuyên gia.</h3>
                  <p>
                    Chúng tôi cam kết mang lại cho bạn sự hài lòng cao nhất, với
                    sản phẩm được thiết kế tinh tế, mang đậm phong cách và sự
                    thoải mái. Mỗi chi tiết đều được chăm chút tỉ mỉ để đảm bảo
                    đáp ứng tốt nhất nhu cầu của bạn.
                  </p>
                </div>
              </div>
            </div>

            <div className="row my-4">
              <div className="col-12">
                <h2 className="noo-sh-title">Gặp Gỡ Đội Ngũ Của Chúng Tôi.</h2>
              </div>
              <div className="col-sm col-lg">
                <div className="hover-team">
                  <div className="our-team">
                    <img
                      src="img/logo.png"
                      alt
                      style={{ width: "400px", height: "auto" }}
                    />
                    <div className="team-content">
                      <h3 className="title">Dương Công Long</h3>
                      <span className="post">Nhà Phát Triển Web.</span>
                    </div>
                  </div>
                  <div className="team-description">
                    <p>
                      Chúng tôi cam kết mang đến cho bạn những sản phẩm chất
                      lượng nhất. Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ và
                      đáp ứng mọi nhu cầu của khách hàng. Chúng tôi luôn tìm
                      kiếm những xu hướng mới nhất để đảm bảo rằng bạn sẽ luôn
                      hài lòng với sự lựa chọn của mình.
                    </p>
                  </div>
                  <hr className="my-0" />
                </div>
              </div>
            </div>
            <div />
          </div>
        </div>
        {/* End About Page */}
        {/* Start Instagram Feed  */}
        <div className="instagram-box">
          <div className="main-instagram owl-carousel owl-theme">
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-01.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-02.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-03.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-04.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-05.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-06.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-07.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-08.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-09.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
            <div className="item">
              <div className="ins-inner-box">
                <img src="images/instagram-img-05.jpg" alt />
                <div className="hov-in">
                  <a href="#">
                    <i className="fab fa-instagram" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* End Instagram Feed  */}
        {/* Start Footer  */}

        {/* End Footer  */}
        {/* Start copyright  */}
        <Footer />
        {/* End copyright  */}
        <a
          href="#"
          id="back-to-top"
          title="Back to top"
          style={{ display: "none" }}
        >
          ↑
        </a>
        {/* ALL JS FILES */}
        {/* ALL PLUGINS */}
      </div>
    </div>
  );
}
