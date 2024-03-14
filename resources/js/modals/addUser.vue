<template>
    <modal name="add-user" height="675">
        <div>
            <div>
                <header class="modal-header" id="modalTitle">
                    <slot name="header">Patiënt toevoegen</slot>
                    <button type="button" class="close-btn" @click="close()">x</button>
                </header>

                <main class="modal-body" id="modalDescription">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Voornaam</label>
                        <input v-model="user.firstname" type="text" class="form-control diss" id="firstname">
                    </div>
                    <div class="mb-3">
                        <label for="middlename" class="form-label">Tussenvoegsel</label>
                        <input v-model="user.middlename" type="text" class="form-control diss" id="middlename">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Achternaam</label>
                        <input v-model="user.lastname" type="text" class="form-control diss" id="lastname">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="user.email" type="email" class="form-control diss" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Wachtwoord</label>
                        <input v-model="user.password" type="password" class="form-control diss" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="dentist" class="form-label">Tandarts</label>
                        <select id="rol" class="form-control mb-3 diss" v-model="users.role_id">
                            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.firstname + " - " + user.role.name }}</option>
                        </select>
                    </div>
                </main>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-primary px-4" @click="addUser()">Aanmaken</button>
                </footer>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    name: 'add-user',
    data() {
        return {
            user: {
                firstname: '',
                middlename: '',
                lastname: '',
                email: '',
                password: '',
                role_id: null,
            },
            users: [],
        };
    },
    mounted() {
        const self = this;
        self.fetchUser();
    },
    methods: {
        close() {
            const self = this;
            self.$modal.hide("add-user");
        },
        addUser() {
            const self = this;
            self.$https.post('/api/users', self.user).then(response => {
                self.$swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Gebruiker toegevoegd.",
                    timer: 3000
                }).then(() => {
                    window.location.href = '/users';
                });
            });
        },
        fetchUser() {
            const self = this;
            self.$https.get('/api/users').then(response => {
                self.users = response.data.filter(user => user.role_id === 2);
            });
        },
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

.close-btn {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: red;
    background: transparent;
    margin-right: 10px;
}
</style>