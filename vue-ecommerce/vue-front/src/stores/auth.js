import axios from "axios";
import router from "@/router";
export default {
  namespaced: true,
  state: {
    authenticated: false,
    user: {},
    token: "",
  },
  getters: {
    authenticated(state) {
      return state.authenticated;
    },
    user(state) {
      return state.user;
    },
  },
  mutations: {
    SET_AUTHENTICATED(state, value) {
      state.authenticated = value;
    },
    SET_USER(state, value) {
      state.user = value;
    },
    SET_TOKEN(state, value) {
      state.token = value;
    },
  },
  actions: {
    login({ commit, state }, data) {
      commit("SET_TOKEN", data.token);
      //console.log(data.token);
      return axios
        .get("http://127.0.0.1:8000/api/user", {
          headers: {
            Authorization: `Bearer ${state.token}`,
          },
        })
        .then(({ data }) => {
          console.log(data);
          commit("SET_USER", data);
          commit("SET_AUTHENTICATED", true);
          if (state.user.role_id == 1) {
            router.push({ name: "dashboard" });
          } else if (state.user.role_id == 2) {
            router.push({ name: "customer" });
          } else if (state.user.role_id == 3) {
            router.push({ name: "vendor" });
          }
        })
        .catch(({ response: { data } }) => {
          commit("SET_USER", {});
          commit("SET_AUTHENTICATED", false);
        });
    },
    async logout({ commit, state }) {
      try {
        await axios.post("http://127.0.0.1:8000/api/logout", null, {
          headers: {
            Authorization: `Bearer ${state.token}`,
          },
        });
      } catch (error) {
        console.error("Logout error:", error);
      } finally {
        commit("SET_USER", {});
        commit("SET_AUTHENTICATED", false);
        commit("SET_TOKEN", "");
        router.push({ name: "home" });
      }
    },
    setToken({ commit }, data) {
      commit("SET_TOKEN", data);
    },
    resetAll({ commit }) {
      commit("SET_USER", {});
      commit("SET_AUTHENTICATED", false);
    },
  },
};
