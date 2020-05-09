import TokenRepository from '@/repositories/token'
import Vue from 'vue'
import VueRouter from 'vue-router'
import appRouter from './modules/app'
import authRouter from './modules/auth'
import store from '@/store'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: 'provinces',
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
  let auth = TokenRepository.getTokenFromStorate() || null

  if (to.matched.some(record => record.meta.require_auth) && !auth) {
    next({
      name: 'login',
    })
  } else if (to.matched.some(record => record.meta.guest) && auth) {
    await fetchUserInfo(auth)
    next({
      name: 'provinces',
    })
  } else {
    await fetchUserInfo(auth)
    next()
  }
})

async function fetchUserInfo (auth) {
  if (auth && !store.state.auth.user.id) {
    await store.dispatch('auth/profile', {})
  }
}

export default router
