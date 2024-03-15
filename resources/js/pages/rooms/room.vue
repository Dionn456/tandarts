<template>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Kamer Informatie</h1>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Kamernaam</label>
                    <input type="text" class="form-control mb-3 diss" v-model="room.name" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Verdieping</label>
                    <input type="text" class="form-control mb-3 diss" v-model="room.floor" />
                </div>
                <div class="form-group">
                    <label class="fw-bold">Kamernummer</label>
                    <input type="text" class="form-control mb-3 diss" v-model="room.number" />
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3 text-center">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary rounded-pill px-3 fw-bold diss" style="width: 200px;"
                    @click="updateRoom($route.params.id)">Opslaan</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            room: {},
        };
    },
    mounted() {
        const self = this
        self.fetchRoom(self.$route.params.id);
    },
    methods: {
        fetchRoom(roomId) {
            const self = this;
            self.$https.get(`/api/room/${roomId}`).then(response => {
                self.room = response.data;
            });
        },
        updateRoom(roomId) {
            const self = this;
            self.$https.post(`/api/room/${roomId}`, self.room);
            self.$swal.fire({
                icon: 'success',
                title: 'Gelukt!',
                text: "Kamer aangepast.",
                timer: 3000
            }).then(() => {
                self.$router.push('/rooms');
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
</style>