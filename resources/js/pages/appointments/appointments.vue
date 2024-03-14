<template>
    <div>
      <changeAppointment ref="change" :appointment="appointment" @finished="getAppointments" />
      <!-- <viewAppointment ref="view" /> -->
      <div class="row">
        <div class="col-lg-4">
            <card title="Afspraak maken">
                <div class="mb-2 row">
                    <label class="col-md-12 col-form-label">Patient toevoegen</label>
                    <div class="col-md-12">
                        <v-select @input="changeUser()" :options="users" v-model="appointment.user" label="name" placeholder="Selecteer gebruiker"></v-select>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="col-md-12 col-form-label">Tandarts</label>
                    <div class="col-md-12">
                        <v-select :options="dentists" v-model="appointment.dentist" label="name" placeholder="Selecteer gebruiker" :disabled="(appointment.user == null)"></v-select>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="col-md-12 mb-1">Beschrijving</label>
                    <div class="col-md-12">
                        <textarea v-model="appointment.description" class="form-control" ></textarea>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="col-md-12 mb-1">Behandelingen</label>
                    <div class="col-md-12">
                        <div v-for="(treatment, index) in appointment.treatments" :key="index" class="mb-1">
                            <v-select  :options="treatments" v-model="treatment.treatment_id" label="name" placeholder="Selecteer behandeling"></v-select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                      <button type="button" class="btn btn-success w-100" @click="addTreatment()">+</button>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label class="col-md-12 mb-1">Tijden</label>
                    <label class="col-md-12 fa-sm">start</label>
                    <div class="col-md-12">
                      <DatePicker type="datetime" :minute-step="15" format="D-M-Y HH:mm" v-model="appointment.start" class="w-100" disabled />
                    </div>
                    <label class="col-md-12 fa-sm mt-1">end</label>
                    <div class="col-md-12">
                      <DatePicker type="datetime" :minute-step="15" format="D-M-Y HH:mm" v-model="appointment.start" class="w-100" disabled />
                    </div>
                </div>
                <div class="row">
                  <button type="button" class="btn btn-primary w-100" @click="addTreatment()">Afpsraak aanmaken</button>
                    
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

  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  import changeAppointment from '../../modals/changeAppointment.vue';

import 'vue-select/dist/vue-select.css';
  
  // import axios from 'axios'
  export default {
    middleware: 'auth',
    components: {
      FullCalendar, DatePicker, changeAppointment
    },
    data() {
      return {
        users: [],
        dentists: [],
        treatments: [],

        calendarOptions: {
          plugins: [ dayGridPlugin, interactionPlugin ],
          initialView: 'dayGridMonth',
          dateClick: this.handleDateclick,
          eventClick: this.handleEventClick,
          events: []
        },
        appointment: {
            start: null,
            end: null,
            user: null,
            dentist: null,
            description: "",
            treatments: [
                { treatment_id: null, }
            ],
        }
      }
    },
    metaInfo () {
      return { title: "Kalender" }
    },
    mounted(){
        const self = this;
        self.getAppointments();
        self.getUsers();
        self.getDentists();
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
      async getDentists() {
        const self = this

        var response = await self.$https.get('/api/users?role_id=2');
        var users = response.data;
        if (users)
        {
            users.forEach(user => {
                user.name = user.firstname + " " + (user.middlename ? user.middlename + " " : "") + user.lastname;
            });

            self.dentists = users;
        }
      },  
      changeUser() {
        const self = this

        if (self.appointment.user == null)
        {
          self.appointment.dentist = null; 
          return;
        } 

        // if user is selected select the default dentist of the user.
        var dentist_id = self.appointment.user.users.find((user) => user.role_id == 2);
        var dentist_id = (dentist_id != null) ? dentist_id.link_user_id : null;
        var dentist =  self.dentists.find((user) => user.id == dentist_id);
        self.appointment.dentist = dentist ? dentist : null;
      },
      addTreatment() {
        const self = this 

        self.appointment.treatments.push({treatment_id: null}); 
      },
      handleDateclick(event) {
        const self = this;

        if (self.appointment.user == null)
        {
          return self.$swal.fire({
              icon: 'error',
              title: 'Fout!',
              text: "Geen gebruiker geselecteerd!",
              timer: 10000
          });
        }

        self.$refs.change.show(event);
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