import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import state from './state';
import actions from './actions';
import mutations from './mutations';
import getters from './getters';

const store = createStore({
  strict: process.env.NODE_ENV !== "production",
  state,
  mutations,
  actions,
  getters,
  plugins: [
    createPersistedState()
  ],
});

export default store;