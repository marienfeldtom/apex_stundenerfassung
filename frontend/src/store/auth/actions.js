import Vue from 'vue'
import axios from 'axios'

export function login({commit}, user) {
  return new Promise((resolve, reject) => {
    commit('auth_request')
    axios.post('/login', user)
      .then(resp => {
        const token_type = resp.data.token_type
        const access_token = resp.data.access_token
        const refresh_token = resp.data.refresh_token
        localStorage.setItem('token_type', token_type)
        localStorage.setItem('access_token', access_token)
        localStorage.setItem('refresh_token', refresh_token)
        Vue.prototype.$http.defaults.headers.common['Authorization'] = token_type + ' ' + access_token
        commit('auth_success', access_token, user)
        resolve(resp)
      })
      .catch(err => {
        commit('auth_error')
        localStorage.removeItem('token_type')
        localStorage.removeItem('access_token')
        localStorage.removeItem('refresh_token')
        reject(err)
      })
  })
}
export function logout({commit}) {
  return new Promise((resolve, reject) => {
    commit('logout')
    localStorage.removeItem('token_type')
    localStorage.removeItem('access_token')
    localStorage.removeItem('refresh_token')
    delete Vue.prototype.$http.defaults.headers.common['Authorization']
    resolve()
  })
}
