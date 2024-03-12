<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-10 m-auto">
        <card v-if="showCard" :title="$t('home')">
          {{ $t('you_are_logged_in') }}
        </card>
      </div>
    </div>
    <div class="row text-center mt-4">
      <div class="col-lg-8 m-auto mb-xl-5 ">
        <h1 class="fw-bold mb-4">Visie</h1>
        <p class="">
          Welkom bij het Tandheelkundig Centrum Hengelo,
          een moderne tandartspraktijk die technologie gebruikt om patiëntenzorg en praktijkbeheer te verbeteren.
          Het centrum wordt geleid door Dr. Jansen, een ervaren tandarts en een visionair op het gebied van digitale
          tandheelkunde.
          Met een team van deskundige tandartsen en ondersteunend personeel,
          streeft het centrum naar een naadloze en efficiënte ervaring voor zowel patiënten als personeel.
        </p>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 m-auto mb-xl-5">
            <h1 class="fw-bold mb-4">Team</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-4" v-for="user in users" :key="user.id">
        <div class="card">
          <img :src="user.image_url" class="card-img-top" :alt="user.name">
          <div class="card-body">
            <h6 class="card-title">{{ user.firstname }}</h6>
            <h6 class="card-title">{{ user.role.name }}</h6>
          </div>
        </div>
      </div>
        </div>
      </div>

      <div class="col-lg-8 m-auto mb-xl-5 ">
        <h1 class="fw-bold mb-4">Behandelingen</h1>
        <p class="">

        </p>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      showCard: true,
      user: {
        firstname: '',
        lastname: '',
        role: '',
      },
      users: []
    };
  },
  middleware: 'auth',

  metaInfo() {
    return { title: this.$t('home') };
  },
  mounted() {
    setTimeout(() => {
      this.showCard = false;
    }, 5000);

    const self = this;
    self.fetchUser();
  },
  methods: {
    fetchUser() {
      const self = this;
      self.$https.get('/api/users').then(response => self.users = response.data);
      console.log(self.users);
    },
  }
};
</script>
