<template>
  <modal name="view-appointment" height="500" >
    <div class="p-1">
      <card title="Informatie" class="m-1"  style="overflow-y:scroll;">
        <div class="mb-1 row">
          <label class="col-md-3 col-form-label" style="font-weight:bold;">Begin tijd</label>
          <div class="col-md-9">
            <label class="col-form-label">{{ moment(appointment.start).format('LLL') }}</label>
          </div>
        </div>
        <div class="mb-1 row">
          <label class="col-md-3 col-form-label" style="font-weight:bold;">Eind tijd</label>
          <div class="col-md-9">
            <label class="col-form-label">{{ moment(appointment.end).format('LLL') }}</label>
          </div>
        </div>
        <div class="mb-1 row" v-if="appointment.room && appointment.room.id">
          <label class="col-md-3 col-form-label" style="font-weight:bold;">Kamer</label>
          <div class="col-md-9">
            <label class="col-form-label">{{ appointment.room.name }}</label>
          </div>
        </div>

        <div class="mb-1 row">
          <label class="col-md-12 mb-1" style="font-weight:bold;">Titel</label>
          <div class="col-md-12">
            {{appointment.title}}
          </div>
        </div>
        <div class="mb-1 row">
          <label class="col-md-12 mb-1 bold" style="font-weight:bold;">Beschrijving</label>
          <div class="col-md-12">
            {{appointment.description}}
          </div>
        </div>
        <div class="mb-1 row" v-if="appointment.treatments && appointment.treatments.length > 0">
          <label class="col-md-6 mb-1 bold" style="font-weight:bold;">Treatment</label>
          <label class="col-md-6 mb-1 bold" style="font-weight:bold;">Price</label>
          <div class="col-md-12">
            <div v-for="treatment in appointment.treatments" :key="treatment.id" class="row">
              <div class="col-md-6">
                {{ treatment.treatment.name }}
              </div>
              <div class="col-md-6">
                €{{ treatment.price }}
              </div>
            </div>
          </div>
        </div>
        <div class="mb-1 row" v-if="appointment.users && appointment.users.length > 0">
          <label class="col-md-6 mb-1 bold" style="font-weight:bold;">Gebruikers</label>
          <label class="col-md-6 mb-1 bold" style="font-weight:bold;">Gebruiker Type</label>
          <div class="col-md-12">
            <div v-for="user in appointment.users" :key="user.id" class="row">
              <div class="col-md-6">
                {{ user.user.firstname }} {{ user.user.lastname }}
              </div>
              <div class="col-md-6">
                {{ user.role.name }}
              </div>
            </div>
          </div>
        </div>

      </card>

    </div>
  </modal>
</template>
<script>

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

import 'vue-select/dist/vue-select.css';

  export default {
    name: 'view-appointment',
    components: { DatePicker },
    data: () => ({
      loading: true,
      appointment: {},
      event: {},
    }),
    async beforeMount() {
      const self = this
      self.loading = true;
      await Promise.all([
      ]);
      self.loading = false;
    },
    methods: {
      show(event) {
        const self = this;
        self.event = event;
        self.getAppointment(event.id);

        self.$modal.show("view-appointment");
      },
      async getAppointment(id) {
        const self = this

        var response = await self.$https.get('/api/appointment/'+id);
        var appointment = response.data;
        if (appointment)
        {
          self.appointment = appointment;
        }
      },
      navigateTo(name, id = null) {
        const self = this
        if (id) self.$router.push({ name: name, params: {id: id}  });
        else self.$router.push({ name: name  });
      },
    }
    
  }
</script>
<style>
  
</style>   