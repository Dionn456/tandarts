<template>
    <div>
      <!-- <addAppointment ref="add" @finished="getAppointments" /> -->
      <!-- <viewAppointment ref="view" /> -->
      <div class="row">
        <div class="col-lg-4 ">
            <card title="Gebruiker">
                <div class="mb-3 row">
                    <label class="col-md-12 col-form-label">Patient toevoegen</label>
                    <div class="col-md-12">
                        <v-select :options="users" v-model="appointment.user" label="name" placeholder="Selecteer gebruiker"></v-select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-12 mb-1">Beschrijving</label>
                    <div class="col-md-12">
                        <textarea v-model="appointment.description" class="form-control" ></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-12 mb-1">Behandelingen</label>
                    <div class="col-md-12">
                        <div v-for="(treatment, index) in appointment.treatments" :key="index">
                            <v-select @change="treatmentChange(treatment, index)"  :options="treatments" v-model="treatment.treatment_id" label="name" placeholder="Selecteer behandeling"></v-select>
                        </div>
                    </div>
                </div>

            </card>
        </div>
        <div class="col-lg-8">
          <card title="Kalender">
            <FullCalendar :options="calendarOptions" />
          </card>
        </div>
      </div>
    </div>
    
  </template>
  
<script>
  import FullCalendar from '@fullcalendar/vue'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import interactionPlugin from '@fullcalendar/interaction'
//   import addAppointment from '../../modals/addAppointment.vue';
//   import viewAppointment from '../../modals/viewAppointment.vue';

import 'vue-select/dist/vue-select.css';
  
  // import axios from 'axios'
  export default {
    middleware: 'auth',
    components: {
      FullCalendar, 
    //   addAppointment, viewAppointment
    },
    data() {
      return {
        users: [],
        treatments: [],

        calendarOptions: {
          plugins: [ dayGridPlugin, interactionPlugin ],
          initialView: 'dayGridMonth',
          dateClick: this.handleDateclick,
          eventClick: this.handleEventClick,
          events: []
        },
        appointment: {
            user: null,
            description: "",
            treatments: [
                { treatment_id: null, }
            ],
        }
      }
    },
    // async asyncData () {
    //   const { data: projects } = await axios.get('/api/projects')
  
    //   return {
    //     projects
    //   }
    // },
  
    metaInfo () {
      return { title: "Kalender" }
    },
    mounted(){
        const self = this;
        self.getAppointments();
        self.getUsers();
        self.getTreatments();
    },
    methods: {
      async getAppointments() {
        const self = this
  
        var response = [] //await self.$https.get('/api/appointments');
        var appointments = response.data;
        if (appointments)
        {
          self.calendarOptions.events = appointments;
        }
      },
      async getTreatments() {
        const self = this
  
        var response = await self.$https.get('/api/treatments');
        var treatments = response.data;
        if (treatments)
        {
          self.treatments = treatments;
        }
      },
      async getUsers() {
        const self = this

        var response = await self.$https.get('/api/users');
        var users = response.data;
        if (users)
        {
            users.forEach(user => {
                user.name = user.firstname + " " + (user.middlename ? user.middlename + " " : "") + user.lastname + " | " + user.phone;
            });

            self.users = users;
        }
      },
      treatmentChange(treatment, index) {
        const self = this 
        console.log("change", treatment, index);
        // if (treatment.treatment_id != null) {
            self.appointment.treatments.push({treatment_id: null}); 
        // }


      },
      handleDateclick(event) {
        const self = this;
        console.warn('date click', event);

        // self.$refs.add.show(event.date);
      },
      handleEventClick(event) {
        const self = this;
        console.warn('event click', event);
  
        // self.$refs.view.show(event.event);
  
      }
    }
  }
</script>
  
  
<style>
  .fc-prev-button, .fc-next-button {
    background-color: #23679e !important; 
    color: #aee2ff !important;
    border: none !important;
  }
  .fc-prev-button {
    border-radius: 20px 0px 0px 20px !important;
  }
  .fc-next-button {
    border-radius: 0px 20px 20px 0px !important;
  }
  .fc-prev-button:hover, .fc-next-button:hover {
    background-color: #4a84be !important; 
    color: #aee2ff !important;
    border: none !important;
  }
  .fc-today-button {
    border-radius: 50px !important;
    padding: 6px 25px !important;
    background-color: #23679e !important;
    opacity: 0.8 !important;
    border: none !important;
  }
  .fc-today-button:hover {
    background-color: #4a84be !important;
    border: none !important;
  }
</style>