function loadAppModules() {
  let modules = []
  let packs   = require.context(
    './app',
    true,
    /[A-Za-z0-9-_,\s]+\.js$/i,
  )

  packs.keys().forEach(key => {
    let matched = key.match(/([A-Za-z0-9-_]+)\./i)
    if (matched && matched.length > 1) {
      modules = [...modules, ...packs(key).default]
    }
  })
  return modules
}

let appModules = loadAppModules()
export default {
  path: '/',
  component: () => import('@/Home'),
  children: [
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('@/view/Dashboard'),
    },
    ...appModules
  ]
}
