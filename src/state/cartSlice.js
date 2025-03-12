import { createSlice } from "@reduxjs/toolkit";

export const cartSlice = createSlice({
    name: "cart",
    initialState: {
        items: localStorage.getItem("cart")
            ? JSON.parse(localStorage.getItem("cart")).items
            : [],
    },
    reducers: {
        addToCart: (state, action) => {
            const { item, quantity } = action.payload;

            // Đảm bảo state.items là mảng
            if (!Array.isArray(state.items)) {
                state.items = []; // Khởi tạo lại nếu không phải mảng
            }

            const existingItem = state.items.find(
                (i) => i.product_id === item.product_id
            );

            if (existingItem) {
                // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
                state.items = state.items.map((i) => {
                    if (i.product_id === item.product_id) {
                        return { ...i, count: i.count + quantity }; // Tăng số lượng của sản phẩm
                    }
                    return i;
                });
            } else {
                // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
                state.items = [...state.items, { ...item, count: quantity }];
            }

            localStorage.setItem(
                "cart",
                JSON.stringify({ items: state.items })
            );
        },

        removeFromCart: (state, action) => {
            const { product_id } = action.payload;
            state.items = state.items.filter(
                (item) => item.product_id !== product_id
            );
            localStorage.setItem(
                "cart",
                JSON.stringify({ items: state.items })
            );
        },

        increaseCount: (state, action) => {
            const { product_id } = action.payload;
            state.items = state.items.map((item) => {
                if (item.product_id === product_id) {
                    return { ...item, count: item.count + 1 }; // Tăng số lượng
                }
                return item;
            });
            localStorage.setItem(
                "cart",
                JSON.stringify({ items: state.items })
            );
        },

        decreaseCount: (state, action) => {
            const { product_id } = action.payload;
            state.items = state.items.map((item) => {
                if (item.product_id === product_id && item.count > 1) {
                    return { ...item, count: item.count - 1 }; // Giảm số lượng
                }
                return item;
            });
            localStorage.setItem(
                "cart",
                JSON.stringify({ items: state.items })
            );
        },

        updateCount: (state, action) => {
            const { product_id, count } = action.payload;
            state.items = state.items.map((item) => {
                if (item.product_id === product_id) {
                    return { ...item, count: count }; // Cập nhật số lượng
                }
                return item;
            });
            localStorage.setItem(
                "cart",
                JSON.stringify({ items: state.items })
            );
        },

        clearCart: (state) => {
            state.items = [];
            localStorage.setItem("cart", JSON.stringify({ items: [] }));
        },
    },
});

export const {
    addToCart,
    removeFromCart,
    increaseCount,
    decreaseCount,
    updateCount,
    clearCart,
} = cartSlice.actions;
export default cartSlice.reducer;
