<template>
  <modal name="change-appointment" height="477">
    <div class="p-1">
      <card :title="moment(date).format('LL')" class="m-1">
        <div>
          <div class="form-group">
            <label for="room">Kamer</label>
            <select id="room" v-model="appointment.roomId" class="form-control w-100 diss mb-4" :disabled="loading">
              <option value="">Selecteer een kamer</option>
              <option v-for="room in rooms" :key="room.id" :value="room.id">{{ room.name }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="start-time">Start Time</label>
            <DatePicker id="start-time" type="time" :minute-step="5" format="HH:mm" v-model="appointment.start" class="w-100 diss mb-2" @change="updateMinEndTime" />
          </div>
          <div class="form-group">
            <label for="end-time">End Time</label>
            <DatePicker id="end-time" type="time" :minute-step="5" format="HH:mm" v-model="appointment.end" :disabled="!appointment.start" class="w-100 diss" />
          </div>
        </div>
      </card>
    </div>
  </modal>
</template>

<script>
import DatePicker from 'vue2-datepicker';

export default {
  name: 'change-appointment',
  components: {
    DatePicker
  },
  data() {
    return {
      loading: true,
      rooms: [],
      date: null,
    };
  },
  props: {
    appointment: {
      type: Object,
    },
  },
  async beforeMount() {
    await this.getRooms();
    this.loading = false;
  },
  methods: {
    show(event) {
      this.date = event.date;
      this.$modal.show("change-appointment");
    },
    async getRooms() {
      const response = await this.$https.get('/api/rooms');
      this.rooms = response.data || [];
    },
    navigateTo(name, id = null) {
      if (id) this.$router.push({ name, params: { id } });
      else this.$router.push({ name });
    },
    updateMinEndTime() {
      if (this.appointment.start) {
        const startTime = new Date(this.appointment.start);
        startTime.setMinutes(startTime.getMinutes() + 5);
        this.appointment.end = startTime;
      }
    }
  }
}
</script>

<style>
/* fix focus */
.diss:focus {
    transform: none;
    box-shadow: none;
    outline: none;
}

.diss {
    border-radius: 7px;
}
</style>
