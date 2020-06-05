<template>
  <div class="q-pa-md">
    <q-layout view="lHh Lpr lff">
      <q-header elevated class="bg-cyan-8">
        <q-toolbar>
          <q-toolbar-title>Apex Energie</q-toolbar-title>
          <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        </q-toolbar>
      </q-header>

      <q-drawer v-model="drawer" show-if-above :breakpoint="400">
        <q-scroll-area
          style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd"
        >
          <q-list padding>
            <q-item-label header>Mitarbeiter Bereich</q-item-label>
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="dashboard" />
              </q-item-section>

              <q-item-section>Dashboard</q-item-section>
            </q-item>

            <q-item active clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="notification_important" />
              </q-item-section>

              <q-item-section>Störungen</q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="access_time" />
              </q-item-section>

              <q-item-section>Zeitdaten</q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="timeline" />
              </q-item-section>

              <q-item-section>Salden</q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="people" />
              </q-item-section>

              <q-item-section>Kunden</q-item-section>
            </q-item>
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="apartment" />
              </q-item-section>

              <q-item-section>Baustellen</q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="build" />
              </q-item-section>

              <q-item-section>Bauvorhaben</q-item-section>
            </q-item>
            <q-separator spaced />
            <q-item-label header>Admin Bereich</q-item-label>
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="library_books" />
              </q-item-section>

              <q-item-section>Verträge</q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="flight_takeoff" />
              </q-item-section>

              <q-item-section>Feiertage</q-item-section>
            </q-item>
          </q-list>
        </q-scroll-area>

        <q-img
          class="absolute-top"
          src="https://cdn.quasar.dev/img/material.png"
          style="height: 150px"
        >
          <div class="absolute-bottom bg-transparent">
            <q-avatar size="56px" class="q-mb-sm">
              <img src="https://cdn.quasar.dev/img/boy-avatar.png" />
            </q-avatar>
            <div class="text-weight-bold">Tom Marienfeld</div>
            <div><q-btn v-if="$store.getters['auth/isLoggedIn']" @click="logout" color="negative">Logout</q-btn></div>
          </div>
        </q-img>
      </q-drawer>

      <q-page-container>
        <router-view></router-view>
      </q-page-container>

    </q-layout>
  </div>
</template>

<script>
  import Swal from 'sweetalert2'
  Swal.fire({
    title: 'Yeah!',
    text: 'Willkommen auf meiner coolen Seite!',
    icon: 'success',
    confirmButtonText: 'Cool'
  })
  export default {
    data () {
      return {
          drawer: true
      }
    },
  mounted () {
    this.$http.all([
      this.$http.get('/products'),
      this.$http.get('/companies')
    ])
      .then(this.$http.spread(function (products, companies) {
        this.products = products.data
        this.companies = companies.data
      }.bind(this)))
      .catch(() => this.hasAPIError = true)
      .then(() => this.isLoading = false)
  },
    methods: {
     logout: function(){
        this.$store.dispatch('auth/logout')
          .then(() => {
            this.$router.push('/login')
          })
      }
    }
}
</script>
