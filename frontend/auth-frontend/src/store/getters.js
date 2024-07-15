export default {
    loggedIn(state) {
        if (state.auth.access_token) {
            return true;
        }
        return false;
    },

    authenticated(state){
        return state.authenticated;
    },
    authenticatedUser(state){
        return state.authenticated_user;
    },
}