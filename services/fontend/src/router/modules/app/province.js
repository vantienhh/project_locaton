export default [
  {
    path: '/provinces',
    name: 'provinces',
    component: () => import('@/views/provinces/List.vue'),
    meta: {
      title: 'Tỉnh thành',
      require_auth: true
    }
  },
]
