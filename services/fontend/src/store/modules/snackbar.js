import {
  SET_SNACKBAR,
  SET_INITIAL_STATE
} from '../mutation-types'

import { forEach } from 'lodash'

const initState = () => {
  return {
    color: '',
    mode: '',
    snackbar: false,
    text: '',
    timeout: 3000,
    x: 'right',
    y: 'top',
  }
}
/**
 * state
 */
const state = {
  color: initState().color,
  mode: initState().mode,
  snackbar: initState().snackbar,
  text: initState().text,
  timeout: initState().timeout,
  x: initState().x,
  y: initState().y
}

/**
 * actions
 */
const actions = {
  showSnackBar({ commit }, payload) {
    let config = {
      color: payload.color !== undefined ? payload.color : initState().color,
      mode: payload.mode !== undefined ? payload.mode : initState().mode,
      snackbar: payload.snackbar !== undefined ? payload.snackbar : true,
      text: payload.text !== undefined ? payload.text : initState().text,
      timeout: payload.timeout !== undefined ? payload.timeout : initState().timeout,
      x: payload.x !== undefined ? payload.x : initState().x,
      y: payload.y !== undefined ? payload.y : initState().y
    }
    commit(SET_SNACKBAR, config)
  }
}

/**
 * mutations
 */
const mutations = {
  [SET_SNACKBAR]: (state, payload) => {
    forEach(payload, (value, key) => {
      state[key] = value
    })
  },
  [SET_INITIAL_STATE]: (state) => {
    state.color = initState().color
    state.mode = initState().mode
    state.snackbar = initState().snackbar
    state.text = initState().text
    state.timeout = initState().timeout
    state.x = initState().x
    state.y = initState().y
  }
}

const getters = {
  color: (state) => state.color,
  mode: (state) => state.mode,
  snackbar: (state) => state.snackbar,
  text: (state) => state.text,
  timeout: (state) => state.timeout,
  x: (state) => state.x,
  y: (state) => state.y
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters
}
