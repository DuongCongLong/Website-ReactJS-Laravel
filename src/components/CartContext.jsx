import React, { createContext, useState, useEffect } from "react";
import axios from "axios";

export const CartContext = createContext();

// CartContext.js
export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Lấy giỏ hàng từ API
  useEffect(() => {
    const fetchCart = async () => {
      const userId = localStorage.getItem('user_id');
      const token = localStorage.getItem('token');

      if (!userId || !token) {
        setLoading(false);
        return;
      }

      try {
        const response = await axios.get(`http://localhost:8000/api/cart/${userId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        setCart(response.data.cart || []);
        setLoading(false);
      } catch (err) {
        setError(err);
        setLoading(false);
      }
    };

    fetchCart();
  }, []);

  const addToCart = (product) => {
    setCart((prevCart) => {
      const existingItem = prevCart.find((item) => item.product_id  === product.product_id);
      if (existingItem) {
        return prevCart.map((item) =>
          item.product_id   === product.product_id 
            ? { ...item, quantity: item.quantity + product.quantity }
            : item
        );
      }
      return [...prevCart, product];
    });
  };

  const removeFromCart = (productId) => {
    setCart((prevCart) => prevCart.filter((item) => item.id !== productId));
  };

  return (
    <CartContext.Provider value={{ cart, setCart, loading, error, addToCart, removeFromCart }}>
      {children}
    </CartContext.Provider>
  );
};

