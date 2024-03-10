<template>
  <div class="row">
    <div class="col-lg-10 m-auto">
      <card v-if="showCard" :title="$t('home')">
        {{ $t('you_are_logged_in') }}
      </card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showCard: true
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
  }
};
</script>
