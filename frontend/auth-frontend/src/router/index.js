import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import HomePage from '@/components/HomePage.vue';
import LoginPage from '@/views/auth/LoginPage.vue';
import RegisterPage from '@/views/auth/RegisterPage.vue';
import ForgotPasswordPage from '@/views/auth/ForgotPasswordPage.vue';
import CompanyDashboard from '@/views/dashboards/CompanyDashboard.vue';
import UniversityDashboard from '@/views/dashboards/UniversityDashboard.vue';
import StudentDashboard from '@/views/dashboards/StudentDashboard.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage,
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
    path: '/company-dashboard',
    name: 'company-dashboard',
    component: CompanyDashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/university-dashboard',
    name: 'university-dashboard',
    component: UniversityDashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/student-dashboard',
    name: 'student-dashboard',
    component: StudentDashboard,
    meta: { requiresAuth: true }
  }
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

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next({ name: 'login' });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
