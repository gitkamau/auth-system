import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import HomePage from '@/components/HomePage.vue';
import LoginPage from '@/views/auth/LoginPage.vue';
import RegisterPage from '@/views/auth/RegisterPage.vue';
import ForgotPasswordPage from '@/views/auth/ForgotPasswordPage.vue';
import MfaSetup from '@/components/MfaSetup.vue';
// import MfaVerify from '@/components/MfaVerify.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage,
    meta: { requiresAuth: true}
  },
  {
    path: '/login',
    name: 'login',
    component: LoginPage,
  },
  {
    path: '/signup',
    name: 'register',
    component: RegisterPage,
    meta: { requiresAuth: false }
  },
  {
    path: '/forgot-password',
    name: 'forgot-password',
    component: ForgotPasswordPage,
    meta: { requiresAuth: false }
  },
  {
    path: '/mfa-verify',
    name: 'MfaVerify',
    component: MfaSetup,
    meta: { requiresAuth: true}
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { top: 0 };
  },
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = store.state.authenticated && localStorage.getItem("access_token");
  const isMfaVerified = store.state.mfa_code;

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next('/login');
    } else if (isAuthenticated && !isMfaVerified && to.path !== '/mfa-verify') {
      next('/mfa-verify');
    } else {
      next();
    }
  } else {
    next();
  }
});


export default router;
