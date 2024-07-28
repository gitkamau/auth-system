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
        localStorage.setItem("auth_email", payload.user.email);
        localStorage.setItem("auth_user_id", payload.user.id);
        localStorage.setItem("auth_name", payload.user.first_name + ' ' + payload.user.last_name);
        localStorage.setItem("auth_role", JSON.stringify(payload.user.role));
        localStorage.setItem("refresh_token", payload.refresh_token);
        localStorage.setItem("phone_number", payload.user.phone_number);
        localStorage.setItem("is_mfa_enabled", payload.user.is_mfa_enabled);
        state.auth.email = localStorage.getItem("auth_email");
        state.auth.user_id = localStorage.getItem("auth_user_id");
        state.auth.name = localStorage.getItem("auth_name");
        state.auth.role = localStorage.getItem("auth_role");
        state.auth.refresh_token = localStorage.getItem("refresh_token");
        state.auth.phone_number = localStorage.getItem("phone_number");
        state.auth.is_mfa_enabled = localStorage.getItem("is_mfa_enabled");
    },
    setUserAndTokenOnRefresh(state) {
        if (localStorage.getItem("access_token") === null) return;
        state.auth.access_token = localStorage.getItem("access_token");
        state.auth.email = localStorage.getItem("auth_email");
        state.auth.user_id = localStorage.getItem("auth_user_id");
        state.auth.name = localStorage.getItem("auth_name");
        state.auth.roles = localStorage.getItem("auth_roles");
        state.auth.user_image = localStorage.getItem("auth_user_image");
    },
    clearAuthUser(state) {
        window.localStorage.clear();
        state.auth.access_token = null;
        state.auth.user_id = null;
        state.auth.email = null;
        state.auth.name = null;
        state.auth.user_image = null;
    },
    setAuthenticated(state, value) {
        state.authenticated = value;
    },

    setAuthenticatedUser(state, value) {
        state.authenticated_user = value;
    },
    setUpdatedUser(state, payload) {
        state.updatedUser = payload;
    },
    setMFACode(state, payload) {
        state.mfaCode = payload;
    },

    setVerifyMFACode(state, payload) {
        state.mfa_code = payload;
    },
}