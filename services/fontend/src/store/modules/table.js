import {
  SET_INITIAL_STATE
} from '../mutation-types'

const initState = () => {
  return {
    items_per_page_options: [5, 10, 15, 20, 30, 50],
    item_per_page: 10
  }
}
/**
 * state
 */
const state = {
  items_per_page_options: initState().items_per_page_options,
  item_per_page: initState().item_per_page,
}

/**
 * actions
 */
const actions = {

}

/**
 * mutations
 */
const mutations = {
  [SET_INITIAL_STATE]: (state) => {
    state.items_per_page_options = initState().items_per_page_options
    state.item_per_page = initState().item_per_page
  }
}

/**
 * getters
 */
const getters = {
  itemsPerPageOptions: (state) => state.items_per_page_options,
  itemsPerPage: (state) => state.item_per_page,
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters
}
