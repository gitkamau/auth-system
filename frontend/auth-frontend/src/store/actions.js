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
      commit("setAuthenticatedUser", user);
      commit("setAuthenticated", true);
    });
  },
  updateUser({ commit }, user) {
    return api.auth.updateUser(user).then((response) => {
      const updatedUser = response.user;
      commit("setUpdatedUser", updatedUser);
    });
  },
  logout({ commit }) {
    return api.auth.logout().then(() => {
      commit("clearAuthUser");
      commit("setAuthenticatedUser", {});
      commit("setAuthenticated", false);
    });
  },
  getMFACodes({ commit }, phoneNumber) {
    return api.auth.getMFACode(phoneNumber).then((response)=>{
      commit("setMFACode", response);
    })
  },
  verifyMFACodes({ commit }, code) {
    return api.auth.verifyMFA(code).then((response)=>{
      commit("setVerifyMFACode", response);
    })
  },
}