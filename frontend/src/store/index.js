import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

import auth from './auth'

Vue.use(Vuex)

Vue.prototype.$http = axios;
Vue.prototype.$http.defaults.baseURL = 'http://localhost:8080/api';
const token_type = localStorage.getItem('token_type')
const access_token = localStorage.getItem('access_token')
if (access_token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token_type + ' ' + access_token
}

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      auth: auth
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  })

  return Store
}
