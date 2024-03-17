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

                <div class="row mb-3">
                    <div class="col">
                        <p class="m-0">Tandarts:</p>
                        <p class="m-0">Assistent:</p>
                        <p class="m-0">Datum Behandeling:</p>
                        <p class="m-0">Behandeling:</p>
                        <div class="form-group">
                            <label class="col-sm-2 col-form-label">Beoordeling:</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input diss" type="radio" id="good" name="beoordeling"
                                        value="goed" v-model="selectedBeoordeling">
                                    <label class="form-check-label" for="goed">Goed</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input diss" type="radio" id="bad" name="beoordeling"
                                        value="slecht" v-model="selectedBeoordeling">
                                    <label class="form-check-label" for="slecht">Slecht</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="opmerking">Opmerking:</label>
                            <textarea type="text" class="form-control diss" id="opmerking"
                                v-model="opmerking"></textarea>
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
            appointment: [],
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
            self.$https.get('/api/appointments').then(response => self.appointment = response.data);
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
    background-color: green; /* Change the background color when checked */
    border-color: green; /* Change the border color when checked */
}
#bad:checked {
    background-color: red;
    border-color: red;
}

</style>