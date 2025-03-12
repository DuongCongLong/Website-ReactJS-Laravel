import React, { lazy, Suspense } from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import { RouterProvider, createBrowserRouter } from 'react-router-dom';
import reportWebVitals from './reportWebVitals';
import App from './App';

// Sử dụng lazy loading
const Home = lazy(() => import('./home/Home'));
const About = lazy(() => import('./scenes/About'));
const CheckOut = lazy(() => import('./scenes/CheckOut'));
const Myaccount = lazy(() => import('./user/Myaccount'));
const Cart = lazy(() => import('./components/Cart'));
const Shop = lazy(() => import('./components/Shop'));
const Detail = lazy(() => import('./product/Detail'));
const Contact = lazy(() => import('./components/Contact'));
const Login = lazy(() => import('./Login/Login'));
const Register = lazy(() => import('./Login/Register'));
const VnPayReturn = lazy(() => import('./scenes/VnPayreturn'));
const PaymentSuccess = lazy(() => import('./scenes/Paymentsuccess'));
const FAQ = lazy(() => import('./home/Faq'));
const Support = lazy(() => import('./home/Support'));
const PostDetail = lazy(() => import('./components/PostDetail'));

const router = createBrowserRouter([
  {
    path: '/',
    element: <App />,
    children: [
      {
        index: true,
        element: (
          <Suspense fallback={<div>Loading Home...</div>}>
            <Home />
          </Suspense>
        ),
      },
      {
        path: 'about',
        element: (
          <Suspense fallback={<div>Loading About...</div>}>
            <About />
          </Suspense>
        ),
      },
      {
        path: 'checkout',
        element: (
          <Suspense fallback={<div>Loading Checkout...</div>}>
            <CheckOut />
          </Suspense>
        ),
      },
      {
        path: 'myaccount',
        element: (
          <Suspense fallback={<div>Loading My Account...</div>}>
            <Myaccount />
          </Suspense>
        ),
      },
      {
        path: 'contact',
        element: (
          <Suspense fallback={<div>Loading Contact...</div>}>
            <Contact />
          </Suspense>
        ),
      },
      {
        path: 'cart',
        element: (
          <Suspense fallback={<div>Loading Cart...</div>}>
            <Cart />
          </Suspense>
        ),
      },
      {
        path: 'shop',
        element: (
          <Suspense fallback={<div>Loading Shop...</div>}>
            <Shop />
          </Suspense>
        ),
      },
      {
        path: 'detail',
        element: (
          <Suspense fallback={<div>Loading Detail...</div>}>
            <Detail />
          </Suspense>
        ),
      },
      {
        path: 'detail/:id',
        element: (
          <Suspense fallback={<div>Loading Detail...</div>}>
            <Detail />
          </Suspense>
        ),
      },
      {
        path: 'login',
        element: (
          <Suspense fallback={<div>Loading Login...</div>}>
            <Login />
          </Suspense>
        ),
      },
      {
        path: 'register',
        element: (
          <Suspense fallback={<div>Loading Register...</div>}>
            <Register />
          </Suspense>
        ),
      },
      {
        path: 'vnpay-return',
        element: (
          <Suspense fallback={<div>Loading VnPay Return...</div>}>
            <VnPayReturn />
          </Suspense>
        ),
      },
      {
        path: 'payment-success',
        element: (
          <Suspense fallback={<div>Loading Payment Success...</div>}>
            <PaymentSuccess />
          </Suspense>
        ),
      },
      {
        path: 'faq',
        element: (
          <Suspense fallback={<div>Loading FAQ...</div>}>
            <FAQ />
          </Suspense>
        ),
      },
      {
        path: 'support',
        element: (
          <Suspense fallback={<div>Loading Support...</div>}>
            <Support />
          </Suspense>
        ),
      },
      {
        path: 'post/:id',
        element: (
          <Suspense fallback={<div>Loading Post Detail...</div>}>
            <PostDetail />
          </Suspense>
        ),
      },
    ],
  },
]);

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <RouterProvider router={router} />
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
