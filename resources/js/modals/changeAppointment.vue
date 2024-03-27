<template>
  <modal name="change-appointment" height="477">
    <div class="p-1">
      <card :title="moment(date).format('LL')" class="m-1">
        <div>
          <div class="mb-2 row">
            <label class="col-md-12 mb-1">Tijden</label>
            <label class="col-md-12 fa-sm">start</label>
            <div class="col-md-12">
              <DatePicker type="time" :time-picker-options="{start: '9:00', step: '00:10',end: '17:00'}" :disabled-time="disableTime" format="HH:mm" v-model="start" class="w-100" @change="updateMinEndTime()" />
            </div>
            <label class="col-md-12 fa-sm mt-1">end</label>
            <div class="col-md-12">
              <DatePicker type="time" :minute-step="15" format="HH:mm" v-model="end" class="w-100" disabled />
            </div>
          </div>
          <div class="row">
            <button type="button" class="btn btn-primary w-100" @click="selectTimes()">Tijden selecteren</button>
          </div>
          <div>
            <label>Afspraken</label>
            <div v-for="event in events" :key="event.id" class="row">
              <label class="col-md-12">
              Tijden {{ moment(event.start).format('HH:mm') }} - {{ moment(event.end).format('HH:mm') }}
              </label>
            </div>
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
      events: [],
      date: null,
      start: null,
      end: null,
    };
  },
  props: {
    appointment: {
      type: Object,
    },
  },
  async beforeMount() {
    this.loading = false;
  },
  methods: {
    show(event, events = []) {
      const self = this
      self.date = event.date;
      self.events = events;
      self.start = null;
      self.end = null;

      self.$modal.show("change-appointment");
    },
    selectTimes() {
      const self = this

      if (self.start == null || self.end == null)
      {
        return self.$swal.fire({
              icon: 'error',
              title: 'Fout!',
              text: "Geen tijd geselecteerd!",
              timer: 10000
          });
      } 
      
      var date = new Date(self.date);
      self.appointment.start = new Date(date.setHours(self.start.getHours(), self.start.getMinutes(), 0));;
      self.appointment.end = new Date(date.setHours(self.end.getHours(), self.end.getMinutes(), 0));

      self.$swal.fire({
          icon: 'success',
          title: 'Succes!',
          text: "Tijden zijn veranderd!",
          timer: 1000
      });

      self.$modal.hide("change-appointment");

    },
    navigateTo(name, id = null) {
      if (id) this.$router.push({ name, params: { id } });
      else this.$router.push({ name });
    },
    updateMinEndTime() {
      const self = this;
      if (self.start) {

        const startTime = new Date(self.start);
        startTime.setMinutes(startTime.getMinutes() + self.calculateTotalDuration());
        self.end = startTime;
      }
    },
    disableTime(datm) {
      const self = this
      var disable = false;

      var date = new Date(self.date);
      date.setHours(datm.getHours());
      date.setMinutes(datm.getMinutes());
      date.setSeconds(datm.getSeconds());

      self.events.forEach(event => {
        var start = new Date(event.start);
        var end = new Date(event.end);
        if (date >= start.setMinutes(start.getMinutes() - (self.calculateTotalDuration())) && date <= end) {
          disable = true;
        }
      });
      var selectedDate = new Date(self.date);
      selectedDate.setHours(17, 0, 0);

      if (date <= selectedDate && date > selectedDate.setMinutes(selectedDate.getMinutes() - self.calculateTotalDuration())) disable = true;
      return disable;

    },
    calculateTotalDuration() {
      const self = this
      var duration = 0;
      self.appointment.treatments.forEach(treatment => {
        duration += treatment.treatment ? treatment.treatment.duration : 0;
      });
      return duration;
    },
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
