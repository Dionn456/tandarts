<template>
    <div class="container mt-5">
        <h1 class="text-center mb-5">{{ user.role.name }} Informatie</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Voornaam</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.firstname" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Tussenvoegsel</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.middlename" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Achternaam</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.lastname" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Email</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.email" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Rol</label>
                    <select id="rol" class="form-control mb-3 diss" v-model="user.role_id">
                        <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="fw-bold">Geboortedatum</label>
                    <input type="text" class="form-control mb-3 diss" v-model="formattedBirthDate" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Telefoon</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.phone" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Wachtwoord</label>
                    <input type="password" class="form-control mb-3 diss" v-model="user.password" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Postcode</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.address.zip_code" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Plaats</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.address.city" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Straat</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.address.street" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Nummer</label>
                    <input type="text" class="form-control mb-3 diss" v-model="user.address.number" />
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary rounded-pill px-3 fw-bold diss" style="width: 200px;"
                    @click="updateUser($route.params.id)">Opslaan</button>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            user: {},
            roles: [],
        };
    },
    mounted() {
        const self = this
        self.fetchUser(self.$route.params.id);
        self.getRoles();
    },
    methods: {
        fetchUser(userId) {
            const self = this;
            self.$https.get(`/api/users/${userId}`).then(async (response) => {
                self.user = response.data;

                if (self.user.address == null) self.user.address = {zip_code: "", city: "", number: "", street: ""};
            });
        },
        getRoles() {
            const self = this;
            self.$https.get('/api/roles').then(async (response) => {
                self.roles = response.data;
            });
        },
        updateUser(userId) {
            const self = this;
            self.$https.post(`/api/users/${userId}`, self.user);
            self.$swal.fire({
                icon: 'success',
                title: 'Gelukt!',
                text: "Gebruiker aangepast.",
                timer: 3000
            }).then(() => {
                self.$router.push('/users');
            });
        },
    },
    computed: {
        formattedBirthDate() {
            return this.user.birth_date.slice(0, 10);
        }
    }
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