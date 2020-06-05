export default function () {
  return {
    status: '',
    access_token: localStorage.getItem('access_token') || '',
    user: {}
  }
}
