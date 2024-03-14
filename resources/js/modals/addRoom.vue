<template>
    <modal name="add-room" height="425">
        <div>
            <div>
                <header class="modal-header" id="modalTitle">
                    <slot name="header">Kamer toevoegen</slot>
                    <button type="button" class="close-btn" @click="close()">x</button>
                </header>

                <main class="modal-body" id="modalDescription">
                    <div class="mb-3">
                        <label for="name" class="form-label">Kamernaam</label>
                        <input v-model="room.name" type="text" class="form-control diss" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="floor" class="form-label">Verdieping</label>
                        <input v-model="room.floor" type="text" class="form-control diss" id="floor">
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Kamernummer</label>
                        <input v-model="room.number" type="text" class="form-control diss" id="number">
                    </div>
                </main>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-primary px-4" @click="addRoom()">Aanmaken</button>
                </footer>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    name: 'add-room',
    data() {
        return {
            room: {
                name: '',
                floor: '',
                number: '',
            },
        };
    },
    methods: {
        close() {
            const self = this;
            self.$modal.hide("add-room");
        },
        addRoom() {
            const self = this;
            self.$https.post('/api/room', self.room).then(response => {
                self.$swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Kamer toegevoegd.",
                    timer: 3000
                }).then(() => {
                    window.location.href = '/rooms';
                });
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
