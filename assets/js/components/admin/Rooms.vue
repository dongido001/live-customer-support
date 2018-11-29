<template>
    <div class="chats">
        <div style="text-align: center"> Chats </div>
        <div 
           v-for="room in rooms" 
           v-bind:key="room.id" 
           class="chat"
           v-on:click="showChat(room.id)"
           v-bind:class="[(room.id == activeRoomId) ? 'active-chat' : '']"
        >
            {{ room.name }}
        </div>
    </div>
</template>

<script>
    export default {
        props: {
          rooms: Array
        },
        data: function () {
            return {
              activeRoomId: null,
            }
        },
        methods: {
            showChat(roomId) {
                this.$emit('show-chat', roomId);
                this.activeRoomId = roomId;
            }
        }
    }
</script>

<style scoped> 
   .chats {
     background-color: #818e817a;
   }
   .chat {
       width: 100%;
       cursor: pointer;
       background: floralwhite;
       color:gray;
       padding: 18px;
       margin: 3px;
   }
   .active-chat {
       border: 3px solid rgb(48, 13, 79);
   }
</style>