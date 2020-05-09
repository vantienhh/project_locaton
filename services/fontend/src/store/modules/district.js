import DistrictRepository from '@/repositories/district'
import {SET_DISTRICTS, SET_DISTRICTS_PAGINATION, SET_DISTRICTS_LOADING, SET_INITIAL_STATE} from '../mutation-types'

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
  async getDistricts({dispatch, commit}, payload = {}) {
    let query        = payload.query || {}
    let districtRepo = (new DistrictRepository(window.axios))

    // set loading
    commit(SET_DISTRICTS_LOADING, true)
    let {success, response} = await districtRepo.getDistricts(query)
    commit(SET_DISTRICTS_LOADING, false)

    if (success) {
      // set list vào state list
      commit(SET_DISTRICTS, response.data)
      // set pagination vào state pagination
      response.meta && response.meta.pagination && commit(SET_DISTRICTS_PAGINATION, response.meta.pagination)

      payload.cb && payload.cb(response.data)
    } else {
      dispatch('snackbar/showSnackBar', {
        color: 'warning',
        text: 'Hệ thống gặp sự cố vui lòng liên hệ admin và thử lại!',
      }, {root: true})
    }
  },
  async getDistrictPopulation({dispatch}, payload = {}) {
    let districtRepo = (new DistrictRepository(window.axios))

    let {success, response} = await districtRepo.districtPopulation({district_id: payload.id})
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
  [SET_DISTRICTS]: (state, list) => {
    state.list = list
  },
  [SET_DISTRICTS_LOADING]: (state, loading) => {
    state.listLoading = loading
  },
  [SET_DISTRICTS_PAGINATION]: (state, pagination) => {
    state.pagination = pagination
  },
  [SET_INITIAL_STATE]: (state) => {
    state.list       = initState().list
    state.pagination = initState().pagination
  },
}

const getters = {
  districts: (state) => state.list,
  districtsLoading: (state) => state.listLoading,
  districtsPagination: (state) => state.pagination,
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
}
