import { createStore } from 'redux';

const initialState = {
  cart: {
    isCartDrawerVisible: false,
    items: [],
  },
};

const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case 'TOGGLE_CART_DRAWER':
      return {
        ...state,
        cart: {
          ...state.cart,
          isCartDrawerVisible: !state.cart.isCartDrawerVisible,
        },
      };
    default:
      return state;
  }
};

const store = createStore(rootReducer);

export default store;
