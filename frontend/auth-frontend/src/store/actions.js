import api from "../api";

export default {
  resetGeneralState({ commit }) {
    commit("resetGeneralState")
  },
  signup({ commit }, user) {
    return api.auth.signup(user).then((response) => {
      localStorage.setItem("access_token", response.data.access_token);
      commit("setUserAndToken", response.data);
    });
  },
  login({ commit }, user) {
    return api.auth.login(user).then((response) => {
      localStorage.setItem("access_token", response.access_token);
      const user = response.user;
      commit("setUserAndToken", response);
      commit("setAuthenticatedUser", user[0]);
      commit("setAuthenticated", true);
    });
  },
  logout({ commit }) {
    return api.auth.logout().then(() => {
      commit("clearAuthUser");
      commit("setAuthenticatedUser", {});
      commit("setAuthenticated", false);
    });
  }
}