import TokenRepository from '@/repositories/token'
import UserRepository from '@/repositories/user'
import router from '@/router'
import {forIn} from 'lodash'
import {SET_USER, SET_INITIAL_STATE} from '../mutation-types'

const initState = () => {
  return {
    user: {},
  }
}
/**
 * state
 */
const state     = {
  user: initState().user,
}

/**
 * actions
 */
const actions = {
  async login({dispatch}, payload) {
    payload                 = payload || {}
    let credential          = {
      email: payload.username,
      password: payload.password,
    }
    let userRepo            = (new UserRepository(window.axios))
    let {success, response} = await userRepo.login(credential)
    if (success) {
      TokenRepository.setTokenToStorage(response.data)
      router.push({name: 'provinces'})
    } else {
      switch (response.code) {
        case 401:
          dispatch('snackbar/showSnackBar', {
            color: 'error',
            text: response.message,
          }, {root: true})
          break
        case 422:
          let msg = []
          forIn(response.data.errors, (err) => {
            if (typeof err === 'string') {
              msg.push('&bullet; ' + err)
            } else {
              msg.push('&bullet; ' + err[0])
            }
          })
          dispatch('snackbar/showSnackBar', {
            color: 'warning',
            text: msg.join('<br />'),
          }, {root: true})
          break
        default:
          dispatch('snackbar/showSnackBar', {
            color: 'warning',
            text: 'Hệ thống gặp sự cố vui lòng liên hệ admin và thử lại!',
          }, {root: true})
          break
      }
    }
  },
  logout({dispatch}) {
    TokenRepository.removeTokenFromStorage()
    dispatch('resetState', {}, {root: true})
    router.push({'name': 'login'})
  },
  async profile({dispatch, commit}) {
    let userRepo            = (new UserRepository(window.axios))
    let {success, response} = await userRepo.profile()
    if (success) {
      commit(SET_USER, response.data)
    } else {
      if (response.code === 401) {
        dispatch('snackbar/showSnackBar', {
          color: 'warning',
          text: 'Phiên làm việc hết hạn!',
        }, {root: true})
        dispatch('auth/logout', {}, {root: true})
      }
      dispatch('snackbar/showSnackBar', {
        color: 'warning',
        text: 'Hệ thống gặp sự cố vui lòng liên hệ admin và thử lại!',
      }, {root: true})
    }
  },
}

/**
 * mutations
 */
const mutations = {
  [SET_USER]: (state, user) => {
    state.user = user
  },
  [SET_INITIAL_STATE]: (state) => {
    state.user = initState().user
  },
}

/**
 * getters
 */
const getters = {
  user: (state) => state.user,
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
}
