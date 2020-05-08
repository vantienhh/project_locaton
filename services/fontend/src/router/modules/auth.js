export default {
  path: '/',
  // component: () => import('@/views/AppBar'),
  children: [
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/Login'),
      meta: {
        title: 'Đăng nhập'
      }
    }
  ]
}
