<template>


  <q-page-container>
    <q-page>
      <div class="row">
        <div class="col-6">
          <q-form @submit.prevent="login" ref="form" v-model="valid">
      <q-input outlined validate-on-blur label="E-Mail-Adresse" required :rules="emailRules"
               type="email" v-model="email" />

      <q-input outlined validate-on-blur label="Passwort" required
               :rules="[(v) => !!v || 'Bitte Ihr Passwort eingeben']" type="password"
               v-model="password" />

      <q-btn :loading="isSending" color="primary" type="submit" label="Login" />
          </q-form>
        </div>
        </div>
    </q-page>
  </q-page-container>


</template>

<script>
    export default {
        data() {
            return {
                valid: false,
                email: "",
                password: "",
                isSending: false,
                emailRules: [
                    (v) => !!v || 'Bitte geben Sie Ihre E-Mail-Adresse an',
                    (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Bitte geben Sie eine gültige E-Mail-Adresse an'
                ],
            }
        },
        methods: {
            login: function () {
                if (this.$refs.form.validate()) {
                    this.valid = true
                    this.isSending = true;

                    let username = this.email;
                    let password = this.password;
                    this.$store.dispatch('auth/login', {username, password})
                        .then(() => {
                            this.isSending = false;
                            this.$router.push('/admin')
                        })
                        .catch(() => this.isSending = false)
                }
            }
        }
    }
</script>
