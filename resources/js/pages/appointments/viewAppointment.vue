<template>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Afspraak Informatie</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="fw-bold">Tijden:</h5>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Begin:</span>
                                <span>{{ appointment.start }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Eind:</span>
                                <span>{{ appointment.end }}</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bold">Medewerkers:</h5>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Tandarts:</span>
                                <span>{{ appointment.dentist.user.firstname }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Assistent:</span>
                                <span>{{ appointment.assistent.user.firstname }}</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bold">Patiënt:</h5>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Patient:</span>
                                <span>{{ appointment.patient.user.firstname }}</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bold">Details:</h5>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Kamer:</span>
                                <span>{{ appointment.room.name }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Status:</span>
                                <span>{{ appointment.status.name }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Beschrijving:</span>
                                <span>{{ appointment.description }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-primary w-100" @click="changeStatus()">Factureren</button>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>





<script>
export default {
    data() {
        return {
            appointment: {},
        };
    },
    mounted() {
        const self = this;
        self.fetchAppointment(self.$route.params.id);
    },
    methods: {
        /* Fetching appointment from API when called */
        fetchAppointment(appointmentId) {
            const self = this;
            // Assuming you're using axios
            self.$https.get(`/api/appointment/${appointmentId}`)
                .then(response => {
                    self.appointment = response.data;
                })
                .catch(error => {
                    console.error('Error fetching appointment:', error);
                });
        },
        changeStatus() {
            const self = this
            self.$https.post('/api/appointment/'+ self.appointment.id +'/invoice').then(response => {
                self.fetchAppointment(self.$route.params.id);
                self.$swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Factuur verzonden.",
                    timer: 3000
                })
            });
        }
    },
};
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