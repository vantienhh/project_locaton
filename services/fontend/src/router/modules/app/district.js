export default [
  {
    path: '/districts',
    name: 'districts',
    component: () => import('@/views/districts/List.vue'),
    meta: {
      title: 'Quận/huyện',
      require_auth: true
    }
  },
]
