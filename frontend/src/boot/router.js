export default ({ router, store, Vue }) => {
  router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      console.log(store)
      if (store.getters["auth/isLoggedIn"]) {
        next()
        return
      }
      next('/login')
    } else {
      next()
    }
  })
}
