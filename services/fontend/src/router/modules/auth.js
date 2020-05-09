export default {
  path: '/',
  component: () => import('@/views/Guest'),
  children: [
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/Login'),
      meta: {
        title: 'Đăng nhập',
        guest: true
      }
    }
  ]
}
