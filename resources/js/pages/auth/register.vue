<template>
  <div class="row">
    <div class="col-lg-7 m-auto">
      <card v-if="mustVerifyEmail" :title="$t('register')">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
      </card>
      <card v-else :title="$t('register')">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <!-- Firstname -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Voornaam</label>
            <div class="col-md-7">
              <input v-model="form.firstname" :class="{ 'is-invalid': form.errors.has('firstname') }"
                class="form-control" type="text" name="firstname">
              <has-error :form="form" field="firstname" />
            </div>
          </div>

          <!-- Lastname -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Achternaam</label>
            <div class="col-md-7">
              <input v-model="form.lastname" :class="{ 'is-invalid': form.errors.has('lastname') }" class="form-control"
                type="text" name="lastname">
              <has-error :form="form" field="lastname" />
            </div>
          </div>

          <!-- Phone -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Telefoon</label>
            <div class="col-md-7">
              <input v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone') }" class="form-control"
                type="text" name="phone">
              <has-error :form="form" field="phone" />
            </div>
          </div>

          <!-- Email -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Email</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control"
                type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Geboortedatum</label>
            <div class="col-md-7">
              <input v-model="form.birthdate" :class="{ 'is-invalid': form.errors.has('birthdate') }"
                class="form-control" type="date" name="birthdate">
              <has-error :form="form" field="geboortedatum" />
            </div>
          </div>


          <!-- Password -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Wachtwoord</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control"
                type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <!-- Password Confirmation -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Herhaal wachtwoord</label>
            <div class="col-md-7">
              <input v-model="form.password_confirmation"
                :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password"
                name="password_confirmation">
              <has-error :form="form" field="password_confirmation" />
            </div>
          </div>

          <!-- Dentist -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Tandarts</label>
            <div class="col-md-7">
              <select id="rol" class="form-control mb-3" v-model="form.role_id" @change="setDentistId">
                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.firstname }}</option>
              </select>
              <has-error :form="form" field="selectedOption" />
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('register') }}
              </v-button>

              <!-- GitHub Register Button -->
              <login-with-github />
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'guest',

  metaInfo() {
    return { title: this.$t('register') }
  },

  mounted() {
    const self = this;
    self.fetchUser();
  },

  data: () => ({
    form: new Form({
      firstname: '',
      lastname: '',
      phone: '',
      email: '',
      password: '',
      birthdate: '',
      password_confirmation: '',
      role_id: null,
      dentist_id: null
    }),
    mustVerifyEmail: false,
    users: [],
  }),

  methods: {
    setDentistId() {
      const selectedUserId = this.form.role_id;
      const selectedUser = this.users.find(user => user.id === selectedUserId);
      if (selectedUser && selectedUser.role_id === 2) {
        this.form.dentist_id = selectedUser.id;
      }
    },
    fetchUser() {
      const self = this;
      self.$https.get('/api/guest/users').then(response => {
        self.users = response.data;
      });
    },
    async register() {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'home' })
      }
    }
  }
}
</script>
