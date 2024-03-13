<template>
    <modal name="change-appointment" height="477">
      <div class="p-1">
        <card :title="moment(date).format('LL')" class="m-1">
          <div>
            Hier kun je een datum selecteren & een kamer selecteren
          </div>

  
        </card>
  
      </div>
    </modal>
  </template>
  <script>

  
    export default {
      name: 'change-appointment',
      components: {  },
      data: () => ({
        loading: true,
        rooms: [],
        date: null,
      }),
      props: {
        appointment: {
          type: Object,
        },
      },
      async beforeMount() {
        const self = this
        self.loading = true;
        await Promise.all([
          self.getRooms()
        ]);
        self.loading = false;
      },
      methods: {
        show(event) {
          const self = this;
        
          self.date = event.date;
          self.$modal.show("change-appointment");
        },
        async getRooms() {
          const self = this
  
          var response = await self.$https.get('/api/rooms');
          var rooms = response.data;
          if (rooms)
          {
            self.rooms = rooms;
          }
        },
        navigateTo(name, id = null) {
          const self = this
          if (id) self.$router.push({ name: name, params: {id: id}  });
          else self.$router.push({ name: name  });
        },
      }
      
    }
  </script>
  <style>
    
  </style>   