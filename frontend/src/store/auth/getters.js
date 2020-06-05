export function isLoggedIn(state) {
  return !!state.access_token
}

export function authStatus(state) {
  return state.status
}
