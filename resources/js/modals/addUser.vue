<template>
    <transition name="modal-fade">
        <div class="modal-backdrop">
            <div class="modal" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription">
                <header class="modal-header" id="modalTitle">
                    <slot name="header">Patiënt toevoegen</slot>
                    <button type="button" class="close-btn" @click="close" aria-label="Close Modal">x</button>
                </header>

                <main class="modal-body" id="modalDescription">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Voornaam</label>
                        <input v-model="user.firstname" type="text" class="form-control" id="firstname">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Achternaam</label>
                        <input v-model="user.lastname" type="text" class="form-control" id="lastname">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="user.email" type="email" class="form-control" id="email">
                    </div>
                </main>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-primary px-4" @click="addUser()">Aanmaken</button>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "Modal",
    data() {
        return {
            user: {
                firstname: '',
                lastname: '',
                email: '',
            }
        };
    },
    methods: {
        close() {
            this.$emit("close");
        },
        addUser() {
            const self = this;
            self.$https.post('/api/users', self.user).then(response => {
                self.$swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Gebruiker toegevoegd.",
                    timer: 10000
                });
                window.location.href = '/users';
            });
        },
    },

};
</script>

<style>
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    width: 60%;
    max-width: 400px;
    max-height: 450px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-footer {
    border-top: 1px solid rgb(227, 231, 233);
    flex-direction: column;
    justify-content: flex-end;
}

.modal-body {
    padding: 20px 10px;
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
}

.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.5s ease;
}
</style>