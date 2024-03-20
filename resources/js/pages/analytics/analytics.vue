<template>
    <div>
      <div class="col-lg-12">
        <card title="Analyse behandelingen / beoordeling">
          <div class="mb-2 row">
            <label class="col-md-12 col-form-label">Selecteer een tandarts</label>
            <div class="col-md-12">
                <v-select @input="changeUser()" :options="dentists" v-model="dentist" label="name" placeholder="Selecteer tandarts"></v-select>
            </div>

            <div>
              <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">Behandeling</th>
                    <th class="th-sm">Aantal behandelingen</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="treatment in treatments" :key="treatment.id">
                    <td class="col3">{{ treatment.name }}</td>
                    <td class="col3">{{ treatment.count_treatments }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </card>
      </div>
    </div>
    
  </template>
  
<script>
  // import DatePicker from 'vue2-datepicker';
  // import 'vue2-datepicker/index.css';


import 'vue-select/dist/vue-select.css';
  
  // import axios from 'axios'
  export default {
    middleware: 'auth',
    components: {
    },
    data() {
      return {
        dentists: [],
        dentist: null,
        treatments: [],
      }
    },
    metaInfo () {
      return { title: "Analyse" }
    },
    mounted(){
        const self = this;
        self.getDentists();
    },
    methods: {
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
      async changeUser() {
        const self = this;
        var response = await self.$https.get('/api/treatments/analytics/'+ self.dentist.id);
        var treatments = response.data;
        if (treatments)
        {
            self.treatments = treatments;
        }
      } 


    },
  }
</script>