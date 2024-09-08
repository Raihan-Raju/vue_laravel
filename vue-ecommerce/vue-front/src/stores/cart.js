const cart = {
  state() {
    return {
      products: [],
      id: 0,
    };
  },
  mutations: {
    addToCart(state, data) {
      // Define the product to search for
      const productToUpdate = data;

      // Find the product with the specified ID
      const foundProduct = state.products.find(
        (product) => product.id === productToUpdate.id
      );

      // If the product is found, update its quantity
      if (foundProduct) {
        // Create a copy of the found product and update its quantity
        const updatedProduct = { ...foundProduct };
        updatedProduct.quantity += productToUpdate.quantity;

        // Replace the existing product in the array with the updated one
        state.products = state.products.map((product) =>
          product.id === updatedProduct.id ? updatedProduct : product
        );
      } else {
        state.products.push(data);
      }
    },
    removecart(state, data) {
      const idToDelete = data;

      // Find the index of the product with the specified id
      const indexToDelete = state.products.findIndex(
        (product) => product.id === idToDelete
      );
      console.log(indexToDelete);

      // Check if the index is found
      if (indexToDelete !== -1) {
        // Remove the product from the array using splice
        state.products.splice(indexToDelete, 1);
      }
    },

    //cart inc and dec
    INCREMENT_QUANTITY(state, product) {
      const foundProduct = state.products.find((p) => p.id === product.id);
      if (foundProduct) {
        foundProduct.quantity++;
      }
    },
    DECREMENT_QUANTITY(state, product) {
      const foundProduct = state.products.find((p) => p.id === product.id);
      if (foundProduct && foundProduct.quantity > 1) {
        foundProduct.quantity--;
      }
    },
    CLEAR_CART(state) {
      state.products = [];
    },
  },
  actions: {
    addcart({ commit, state }, payload) {
      commit("addToCart", payload);
    },
    deleteCart({ commit, state }, payload) {
      commit("removecart", payload);
    },
    // inc & dec
    incrementQuantity({ commit }, product) {
      commit("INCREMENT_QUANTITY", product);
    },
    decrementQuantity({ commit }, product) {
      commit("DECREMENT_QUANTITY", product);
    },
    clearCart({ commit }) {
      commit("CLEAR_CART");
    },
  },
  getters: {
    totalPrice(state) {
      return state.products.reduce((total, product) => {
        return total + product.price * product.quantity;
      }, 0);
    },
    totalItems(state) {
      return state.products.reduce((total, product) => {
        return total + product.quantity;
      }, 0);
    },
  },
};
export default cart;
