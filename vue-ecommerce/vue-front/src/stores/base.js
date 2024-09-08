const base = {
  state() {
    return {
      url: 'http://127.0.0.1:8000/api/'
    };
  },
  getters: {
    url(state) {
      return state.url;
    },
  },
};
export default base;
