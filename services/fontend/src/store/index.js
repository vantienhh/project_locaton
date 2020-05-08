import {forEach} from 'lodash'
import Vue from 'vue'
import Vuex from 'vuex'
import createLogger from 'vuex/dist/logger'
import {SET_INITIAL_STATE} from './mutation-types'

Vue.use(Vuex)

function loadModules() {
  const packs = require.context(
    // The relative path of the components folder
    './modules',
    // Whether or not to look in subfolders
    true,
    // The regular expression used to match base component filenames
    /[A-Za-z0-9-_,\s]+\.js$/i,
  )

  let modules = {}

  packs.keys().forEach(key => {
    const matched = key.match(/([A-Za-z0-9-_]+)\./i)
    if (matched && matched.length > 1) {
      const module = matched[1]
      modules[module] = packs(key)
    }
  })
  return modules
}

const modules = loadModules()
const debug   = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  // strict: debug,
  state: {},
  actions: {
    resetState({commit}) {
      forEach(modules, (module, name) => {
        // eslint-disable-next-line no-undef
        if (module.mutations[SET_INITIAL_STATE]) {
          if (module.namespaced) {
            commit(name + '/' + SET_INITIAL_STATE)
          } else {
            commit(SET_INITIAL_STATE)
          }
        }
      })
    },
  },
  modules: {
    ...modules,
  },
  plugins: debug ? [createLogger()] : [],
})

