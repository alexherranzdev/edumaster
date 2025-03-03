import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import StudentDashboardView from '../views/StudentDashboardView.vue'
import StudentsView from '../views/StudentsView.vue'
import TeachersView from '../views/TeachersView.vue'
import WorksheetsView from '../views/WorksheetsView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    beforeEnter: (to, from, next) => {
      const authStore = useAuthStore()
      if (authStore.isAuthenticated) {
        next('/dashboard')
      } else {
        next('/login')
      }
    },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => {
      const authStore = useAuthStore()
      return authStore.isAuthenticated && authStore.isStudent ? StudentDashboardView : DashboardView
    },
    meta: { requiresAuth: true },
  },
  { path: '/login', name: 'login', component: LoginView },
  {
    path: '/students',
    name: 'students',
    component: StudentsView,
    meta: { requiresAuth: true, isTeacher: true },
  },
  {
    path: '/teachers',
    name: 'teachers',
    component: TeachersView,
    meta: { requiresAuth: true, isTeacher: true },
  },
  {
    path: '/worksheets',
    name: 'worksheets',
    component: WorksheetsView,
    meta: { requiresAuth: true },
  },
  {
    path: '/logout',
    name: 'logout',
    beforeEnter: (to, from, next) => {
      const authStore = useAuthStore()
      authStore.logout()
      next('/')
    },
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  }

  if (to.meta.isTeacher && !authStore.isTeacher) {
    next('/dashboard')
  }

  next()
})

export default router
