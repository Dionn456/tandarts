<template>
    <div class="container">
        <div class="row mb-1">
            <div class="col-3">
                <input type="text" v-model="search" class="form-control form-control-sm narrow-search diss"
                    placeholder="Zoeken...">
            </div>
        </div>
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="th-sm">Begin</th>
                    <th class="th-sm">Einde</th>
                    <th class="th-sm">Patiënt</th>
                    <th class="th-sm">Tandarts</th>
                    <th class="th-sm text-center">Acties</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="appointment in filteredUsers" :key="appointment.id">
                    <td class="col-2">{{ appointment.start }}</td>
                    <td class="col-2">{{ appointment.end }}</td>
                    <td class="col-2"><span v-if="appointment.patient">{{ appointment.patient.user.firstname }}</span></td>
                    <td class="col-2"><span v-if="appointment.dentist">{{ appointment.dentist.user.firstname }}</span></td>
                    <td class="col-1">
                        <div v-if="user.role_id !== 4" class="d-flex justify-content-center gap-3">
                            <a :href="'/viewAppointment/' + appointment.id" class="float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="orange" width="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <a @click="removeAppointment(appointment.id)" class="float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="red" width="20">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </div>
                        <div class="d-flex justify-content-center gap-3" v-else>
                            <a :href="'/enquete/' + appointment.id">Enquête</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
import { mapGetters } from 'vuex'


export default {
    data() {
        return {
            search: '',
            appointments: [],
        };
    },
    mounted() {
        const self = this;
        self.fetchAppointments();
    },
    methods: {
        /* Fetching users from API when called */
        fetchAppointments() {
            const self = this;
            self.$https.get('/api/appointments').then(response => self.appointments = response.data);
        },
        /* Confirming deletion of room and then sending delete request to API */
        removeAppointment(appointmentId) {
            const self = this;
            if (confirm('Weet je zeker dat je de afspraak wilt verwijderen?')) {
                self.$https.delete(`/api/appointment/${appointmentId}`)
                    .then(response => {
                        /* Removing deleted room from rooms array */
                        const index = self.appointments.findIndex(appointment => appointment.id === appointmentId);
                        if (index !== -1) {
                            self.appointments.splice(index, 1);
                        }

                        /* Showing success message using sweetalert */
                        self.$swal.fire({
                            icon: 'success',
                            title: 'Gelukt!',
                            text: "Afspraak verwijderd.",
                            timer: 3000
                        });
                    })
                    .catch(error => {
                        console.error('Afspraak niet kunnen verwijderen:', error);
                    });
            }
        },
    },
    computed: {
        /* Filtering users based on search string */
        filteredUsers() {
            const self = this;
            return self.appointments.filter(appointment => {
                return appointment.start.toLowerCase().includes(self.search.toLowerCase()) ||
                    appointment.end.toLowerCase().includes(self.search.toLowerCase()) ||
                    appointment.description.toLowerCase().includes(self.search.toLowerCase());
            });
        },
        ...mapGetters({
            user: 'auth/user'
        }),
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