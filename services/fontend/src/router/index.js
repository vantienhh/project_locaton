import Vue from 'vue'
import VueRouter from 'vue-router'
import appRouter from './modules/app'
import authRouter from './modules/auth'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: 'dashboard',
  },
  authRouter,
  appRouter,
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach(async (to, from, next) => {
  document.title = 'FontEnd | ' + to.meta.title

  console.log('to', to)
  console.log('from', from)
  let auth = false
  if (to.matched.some(record => record.meta.require_auth) && !auth) {
    next({
      name: 'login'
    })
  }
})


export default router
