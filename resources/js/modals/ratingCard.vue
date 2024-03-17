<template>
    <div class="container my-5">
        <div class="card mx-auto"
            style="max-width: 374px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title text-center">{{ user.firstname }}</h5>
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <p class="m-0 text-center">Birth Date: {{ user.birth_date }}</p>
                    </div>
                </div>
                <hr>

                <div class="row mb-3" v-for="(appointment, index) in appointments" :key="index">
                    <div class="col">
                        <p class="m-0">Tandarts: {{ appointment.dentist.user.firstname }}</p>
                        <p class="m-0">Assistent: {{ appointment.assistent.user.firstname }}</p>
                        <p class="m-0">Datum Behandeling: {{ appointment.start }} tot {{ appointment.end }}</p>
                        <p class="m-0">Behandeling: {{ appointment }}</p>
                        <div class="form-group">
                            <label class="col-sm-2 col-form-label">Beoordeling:</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input diss" type="radio" :id="'good' + index" :name="'beoordeling' + index"
                                        value="goed" v-model="appointment.selectedBeoordeling">
                                    <label class="form-check-label" :for="'goed' + index">Goed</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input diss" type="radio" :id="'bad' + index" :name="'beoordeling' + index"
                                        value="slecht" v-model="appointment.selectedBeoordeling">
                                    <label class="form-check-label" :for="'slecht' + index">Slecht</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="opmerking">Opmerking:</label>
                            <textarea type="text" class="form-control diss" :id="'opmerking' + index"
                                v-model="appointment.opmerking"></textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="text-center">
                    <button type="button" class="btn btn-primary">Versturen</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            selectedBeoordeling: 'goed',
            opmerking: '',
            appointments: [],
        }
    },
    props: {
        user: Object,
        loading: Boolean
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    mounted() {
        const self = this;
        self.fetchDentist();
    },
    methods: {
        fetchDentist() {
            const self = this;
            self.$https.get('/api/appointments').then(response => self.appointments = response.data);
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