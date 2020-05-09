import ProvinceRepository from '@/repositories/province'
import {SET_PROVINCES, SET_PROVINCES_PAGINATION, SET_PROVINCES_LOADING, SET_INITIAL_STATE} from '../mutation-types'

const initState = () => {
  return {
    list: [],
    listLoading: false,
    pagination: {
      total: 0,
      count: 0,
      per_page: 20,
      current_page: 1,
      total_pages: 1,
    },
  }
}

const state = {
  list: initState().list,
  listLoading: initState().listLoading,
  pagination: initState().pagination,
}

const actions = {
  async getProvinces({dispatch, commit}, payload = {}) {
    let query        = payload.query || {}
    let provinceRepo = (new ProvinceRepository(window.axios))

    // set loading
    commit(SET_PROVINCES_LOADING, true)
    let {success, response} = await provinceRepo.getProvinces(query)
    commit(SET_PROVINCES_LOADING, false)

    if (success) {
      // set list vào state list
      commit(SET_PROVINCES, response.data)
      // set pagination vào state pagination
      response.meta && response.meta.pagination && commit(SET_PROVINCES_PAGINATION, response.meta.pagination)

      payload.cb && payload.cb(response.data)
    } else {
      dispatch('snackbar/showSnackBar', {
        color: 'warning',
        text: 'Hệ thống gặp sự cố vui lòng liên hệ admin và thử lại!',
      }, {root: true})
    }
  },
  async getProvincePopulation({dispatch}, payload = {}) {
    let provinceRepo = (new ProvinceRepository(window.axios))

    let {success, response} = await provinceRepo.provincePopulation({province_id: payload.id})
    if (success) {
      payload.cb && payload.cb(response.data)
    } else {
      dispatch('snackbar/showSnackBar', {
        color: 'warning',
        text: 'Hệ thống gặp sự cố vui lòng liên hệ admin và thử lại!',
      }, {root: true})
    }
  },
}

const mutations = {
  [SET_PROVINCES]: (state, list) => {
    state.list = list
  },
  [SET_PROVINCES_LOADING]: (state, loading) => {
    state.listLoading = loading
  },
  [SET_PROVINCES_PAGINATION]: (state, pagination) => {
    state.pagination = pagination
  },
  [SET_INITIAL_STATE]: (state) => {
    state.list       = initState().list
    state.pagination = initState().pagination
  },
}

const getters = {
  provinces: (state) => state.list,
  provincesLoading: (state) => state.listLoading,
  provincesPagination: (state) => state.pagination,
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
}
