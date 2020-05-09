import Vue from 'vue'
import axios from "axios"
import TokenRepository from '@/repositories/token'
import store from '@/store'

axios.defaults.baseURL = process.env.VUE_APP_API_URL || ''
axios.defaults.headers.post['Content-Type'] = 'application/json'
axios.defaults.headers.post['Accept'] = 'application/json'
axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest'

let config = {
  // baseURL: process.env.baseURL || process.env.apiUrl || ""
  // timeout: 60 * 1000, // Timeout
  // withCredentials: true, // Check cross-site Access-Control
}

const _axios = axios.create(config)

_axios.interceptors.request.use(
  function(config) {
    config.headers.Authorization = TokenRepository.getTokenFromStorate()
    store.dispatch('app/setLoading', true)
    return config
  },
  function(error) {
    // Do something with request error
    return Promise.reject(error)
  }
)

// Add a response interceptor
_axios.interceptors.response.use(
  function(response) {
    store.dispatch('app/setLoading', false)
    return response
  },
  function(error) {
    store.dispatch('app/setLoading', false)
    return Promise.reject(error)
  }
)

Plugin.install = function(Vue) {
  Vue.axios = _axios
  window.axios = _axios
  Object.defineProperties(Vue.prototype, {
    axios: {
      get() {
        return _axios
      }
    },
    $axios: {
      get() {
        return _axios
      }
    },
  })
}

Vue.use(Plugin)

export default Plugin
