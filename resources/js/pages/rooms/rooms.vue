<template>
    <div class="container">
        <div class="row mb-1">
            <div class="col-3">
                <input type="text" v-model="search" class="form-control form-control-sm narrow-search diss" placeholder="Zoeken...">
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-primary" @click="openModal()">Kamer toevoegen</button>
                <addRoom class="flex justify-content-center align-content-center" />
            </div>
        </div>

        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="th-sm">Kamernaam</th>
                    <th class="th-sm">Verdieping</th>
                    <th class="th-sm">Kamernummer</th>
                    <th class="th-sm text-center">Acties</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="room in filteredRooms" :key="room.id">
                    <td class="col3">{{ room.name }}</td>
                    <td class="col-3">{{ room.floor }}</td>
                    <td class="col-3">{{ room.number }}</td>
                    <td class="col-1">
                        <div class="d-flex justify-content-center gap-3">
                            <a :href="'/room/' + room.id" class="float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="orange" width="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <a @click="removeRoom(room.id)" class="float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" width="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import addRoom from '../../modals/addRoom.vue';

export default {
    data() {
        return {
            search: '',
            rooms: [],
            visible: false,
        };
    },
    components: {
        addRoom
    },
    mounted() {
        const self = this;
        self.fetchRooms();
    },
    methods: {
        /* Method to open add-room modal */
        openModal() {
            const self = this;
            self.$modal.show("add-room");
        },
        /* Fetching rooms from API when called */
        fetchRooms() {
            const self = this;
            self.$https.get('/api/rooms').then(response => self.rooms = response.data);
        },
        /* Confirming deletion of room and then sending delete request to API */
        removeRoom(roomId) {
            const self = this;
            if (confirm('Weet je zeker dat je de kamer wilt verwijderen?')) {
                self.$https.delete(`/api/room/${roomId}`)
                    .then(response => {
                        /* Removing deleted room from rooms array */
                        const index = self.rooms.findIndex(room => room.id === roomId);
                        if (index !== -1) {
                            self.rooms.splice(index, 1);
                        }

                        /* Showing success message using sweetalert */
                        self.$swal.fire({
                            icon: 'success',
                            title: 'Gelukt!',
                            text: "Kamer verwijderd.",
                            timer: 3000
                        });
                    })
                    .catch(error => {
                        console.error('Kamer niet kunnen verwijderen:', error);
                    });
            }
        },
    },
    computed: {
        /* Filtering rooms based on search string */
        filteredRooms() {
            const self = this;
            return self.rooms.filter(room => {
                return room.name.toLowerCase().includes(self.search.toLowerCase()) ||
                    room.floor.toLowerCase().includes(self.search.toLowerCase()) ||
                    room.number.toLowerCase().includes(self.search.toLowerCase());
            });
        }
    }
}
</script>