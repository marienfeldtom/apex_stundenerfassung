// eslint-disable-next-line camelcase
export function auth_request (state) {
  state.status = 'loading'
}

// eslint-disable-next-line camelcase
export function auth_success (state, access_token, user) {
  state.status = 'success'
  // eslint-disable-next-line camelcase
  state.access_token = access_token
  state.user = user
}
// eslint-disable-next-line camelcase
export function auth_error (state) {
  state.status = 'error'
}
export function logout (state) {
  state.status = ''
  state.access_token = ''
}
