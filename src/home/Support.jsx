import React from "react";
import Header from "../components/Header";
import Footer from "../components/Footer";

export default function Support() {
  const faqs = [
    {
      question: "Làm thế nào để đặt hàng?",
      answer: "Bạn có thể đặt hàng trực tiếp qua website hoặc gọi đến số hotline hỗ trợ.",
    },
    {
      question: "Tôi có thể đổi trả hàng không?",
      answer: "Chúng tôi hỗ trợ đổi trả trong vòng 14 ngày với các sản phẩm còn nguyên tem mác.",
    },
    {
      question: "Phí vận chuyển được tính như thế nào?",
      answer: "Chúng tôi miễn phí vận chuyển cho đơn hàng.",
    },
    {
      question: "Thời gian giao hàng dự kiến là bao lâu?",
      answer: "Thời gian giao hàng từ 3-5 ngày làm việc tùy thuộc vào khu vực của bạn.",
    },
    {
      question: "Làm thế nào để liên hệ hỗ trợ?",
      answer: "Bạn có thể liên hệ với chúng tôi qua email duongconglong@gmail.com hoặc gọi 0396813911.",
    },
  ];

  return (
    <div>
      <Header />
      <div className="all-title-box">
        <div className="container">
          <div className="row">
            <div className="col-lg-12">
              <ul className="breadcrumb">
                <li className="breadcrumb-item">
                  <a href="/">Trang chủ</a>
                </li>
                <li className="breadcrumb-item active">Câu hỏi thường gặp</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div className="container my-5">
        <h1 className="text-center mb-4">Câu hỏi thường gặp</h1>
        <div className="accordion" id="faqAccordion">
          {faqs.map((faq, index) => (
            <div className="card mb-3" key={index}>
              <div
                className="card-header"
                id={`heading${index}`}
                style={{ cursor: "pointer" }}
                data-toggle="collapse"
                data-target={`#collapse${index}`}
                aria-expanded="false"
                aria-controls={`collapse${index}`}
              >
                <h5 className="mb-0">{faq.question}</h5>
              </div>
              <div
                id={`collapse${index}`}
                className="collapse"
                aria-labelledby={`heading${index}`}
                data-parent="#faqAccordion"
              >
                <div className="card-body">{faq.answer}</div>
              </div>
            </div>
          ))}
        </div>
      </div>
      <Footer />
    </div>
  );
}
