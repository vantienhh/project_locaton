import {
  SET_DRAWER,
  SET_LOADING,
  SET_MINI_DRAWER,
  SET_INITIAL_STATE
} from '../mutation-types'

const initState = () => {
  return {
    drawer: null,
    miniDrawer: false,
    loading: false
  }
}
/**
 * state
 */
const state = {
  drawer: initState().drawer,
  miniDrawer: initState().miniDrawer,
  loading: initState().loading,
}

/**
 * actions
 */
const actions = {
  setDrawer ({ commit }, payload) {
    commit(SET_DRAWER, !!payload)
  },
  setMiniDrawer ({ commit }, payload) {
    commit(SET_MINI_DRAWER, !!payload)
  },
  setLoading ({ commit }, payload) {
    commit(SET_LOADING, !!payload)
  }
}

/**
 * mutations
 */
const mutations = {
  [SET_LOADING]: (state, loading) => {
    state.loading = loading
  },
  [SET_DRAWER]: (state, drawer) => {
    state.drawer = drawer
  },
  [SET_MINI_DRAWER]: (state, miniDrawer) => {
    state.miniDrawer = miniDrawer
  },
  [SET_INITIAL_STATE]: (state) => {
    state.drawer = initState().drawer
    state.miniDrawer = initState().miniDrawer
  }
}

/**
 * getters
 */
const getters = {
  drawer: (state) => state.drawer,
  miniDrawer: (state) => state.miniDrawer,
  loading: (state) => state.loading,
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters
}
