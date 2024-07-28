import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
// import vuetify from './plugins/vuetify'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
// import Notifications from "vue-notification";


import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
  components,
  directives,
});


createApp(App)
  .use(router)
  .use(store)
  .use(vuetify)
  // .use(Notifications)
  .mount('#app')