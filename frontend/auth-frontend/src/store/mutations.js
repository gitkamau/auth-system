import initial_state from "./state.js";

export default {
    resetGeneralState(state) {
        Object.assign(state, initial_state)
    },
    makingApiRequest(state, payload) {
        state.isLoading = payload;
    },
    setUserAndToken(state, payload) {
        if (localStorage.getItem("access_token") === null) return;
        state.auth.access_token = localStorage.getItem("access_token");
        localStorage.setItem("auth_email", payload.user[0].email);
        localStorage.setItem("auth_user_id", payload.user[0].id);
        localStorage.setItem("auth_name", payload.user[0].name);
        localStorage.setItem("auth_roles", JSON.stringify(payload.user[0].roles));
        localStorage.setItem("auth_user_logo", JSON.stringify(payload.user[0].user_logo));
        state.auth.email = localStorage.getItem("auth_email");
        state.auth.user_id = localStorage.getItem("auth_user_id");
        state.auth.name = localStorage.getItem("auth_name");
        state.auth.roles = localStorage.getItem("auth_roles");
        state.auth.user_logo = localStorage.getItem("auth_user_logo");
    },
    setUserAndTokenOnRefresh(state) {
        if (localStorage.getItem("access_token") === null) return;
        state.auth.access_token = localStorage.getItem("access_token");
        state.auth.email = localStorage.getItem("auth_email");
        state.auth.user_id = localStorage.getItem("auth_user_id");
        state.auth.name = localStorage.getItem("auth_name");
        state.auth.roles = localStorage.getItem("auth_roles");
        state.auth.user_logo = localStorage.getItem("auth_user_logo");

    },
    clearAuthUser(state) {
        window.localStorage.clear();
        state.auth.access_token = null;
        state.auth.user_id = null;
        state.auth.email = null;
        state.auth.name = null;
        state.auth.user_logo = null;
    }
}