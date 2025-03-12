import "./App.css";
import { Outlet } from "react-router-dom"; // Import Outlet để hiển thị các route con
import { CartProvider } from "./components/CartContext"; // Import CartProvider
import { Provider } from "react-redux"; // Import Provider từ react-redux
import store from "./components/store"; // Giả sử store được cấu hình trong tệp store.js

function App() {
  return (
    <Provider store={store}>  {/* Bao bọc toàn bộ ứng dụng trong Provider */}
      <CartProvider> {/* CartProvider bao bọc phần liên quan đến giỏ hàng */}
        <div className="App">
          <Outlet />
        </div>
      </CartProvider>
    </Provider>
  );
}

export default App;
