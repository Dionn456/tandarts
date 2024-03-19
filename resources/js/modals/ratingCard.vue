<template>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Afspraak Informatie</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="fw-bold">Enquête:</h5>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span>Patiënt:</span>
                                <span>{{ appointments.patient.user.firstname }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span>Geboortedatum:</span>
                                <span>{{ appointments.patient.user.birth_date }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span>Tandarts:</span>
                                <span>{{ appointments.dentist.user.firstname }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span>Datum behandeling:</span>
                                <span>{{ appointments.start }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span>Behandeling:</span>
                                <span v-for="treatment in appointments.treatments" :key="treatment.id">{{
                                    treatment.treatment.name }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Beoordeling:</span>
                                <div>
                                    <div class="form-check form-check-inline justify-content-end">
                                        <input class="form-check-input diss" type="radio" id="good" name="rating"
                                            value="goed" v-model="review.rating">
                                        <label class="form-check-label" for="good">Goed</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-end">
                                        <input class="form-check-input diss" type="radio" id="bad" name="rating"
                                            value="slecht" v-model="review.rating">
                                        <label class="form-check-label" for="bad">Slecht</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span>Opmerking:</span>
                                <textarea name="" id="" cols="40" rows="3" v-model="review.comment"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary px-4 diss" @click="addReview()">Aanmaken</button>
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
            appointments: [],
            review: {
                rating: '',
                comment: ''
            },
        }
    },
    mounted() {
        const self = this;
        self.fetchData(self.$route.params.id);
    },
    methods: {
        fetchData(appointmentId) {
            const self = this;
            self.$https.get(`/api/appointment/${appointmentId}`)
                .then(response => {
                    self.appointments = response.data;
                })
                .catch(error => {
                    console.error('Error fetching appointment:', error);
                });
        },
        addReview() {
            const self = this;
            self.review.patientId = self.appointments.patient.user.id;
            self.review.appointmentId = self.appointments.id;
            self.$https.post('/api/review', self.review).then(response => {
                self.$swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Review geplaatst!.",
                    timer: 3000
                }).then(() => {
                    window.location.href = '/viewAppointments';
                });
            });
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

#good:checked {
    background-color: green;
    border-color: green;
}

#bad:checked {
    background-color: red;
    border-color: red;
}
</style>