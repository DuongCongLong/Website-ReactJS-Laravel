import { configureStore } from "@reduxjs/toolkit";
import cartReducer from "../state/cartSlice";
import userSlice from "./userSlice";
export default configureStore({
    reducer: {
        cart: cartReducer,
        user: userSlice,
    },
});
