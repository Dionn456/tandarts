<template>
    <div>
      <div class="col-lg-12">
        <card title="Aantal behandelingen" class="mb-2">
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
                  <tr v-for="treatment in aTreatments" :key="treatment.id">
                    <td class="col3">{{ treatment.name }}</td>
                    <td class="col3">{{ treatment.count_treatments }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </card>

        <card title="Reviews">
          <div class="mb-2 row">
            <div>
              <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">Behandeling</th>
                    <th class="th-sm">Aantal beoordeelde behandelingen</th>
                    <th class="th-sm">Tevredenheid</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="treatment in rTreatments" :key="treatment.id">
                    <td class="col3">{{ treatment.name }}</td>
                    <td class="col3">{{ treatment.ratings }}</td>
                    <td class="col3"><span v-if="treatment.rating_good != null">{{ (treatment.rating_good / treatment.ratings) * 100 }}%</span><span v-else>-</span></td>
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
        aTreatments: [],
        rTreatments: [],
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
        var data = response.data;
        if (data)
        {
            self.aTreatments = data.amount;
            self.rTreatments = data.reviews;
        }
      } 


    },
  }
</script>