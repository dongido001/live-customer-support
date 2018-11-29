
<template>
    <div>
        <Login
            v-if="!authenticated"
            v-on:authenticated="setAuthenticated" 
        />
        <div v-else class="admin-wrapper">
            <Rooms 
              :rooms="rooms" 
              v-on:show-chat="joinRoom"
            />
            <Messages  
                v-on:new-message="addMessage"
                :messages="messages"
                :userId="userId"
            />
        </div>
    </div>
</template>

<script>
    import Messages from './admin/Messages.vue';
    import Login from './admin/Login.vue';
    import Rooms from './admin/Rooms.vue';
    import Key from '../../../config.js';

    import { ChatManager, TokenProvider } from '@pusher/chatkit-client';
    
    let currentUser = null;
    
    export default {
        components: {
           Messages,
           Login,
           Rooms
        },
        data: function () {
            return {
              authenticated: false,
              roomId: "",
              messages: [],
              userId: "",
              rooms: []
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {
            setAuthenticated(userId) {
            
                let chatManager = new ChatManager({
                    instanceLocator: Key.instanceLocator,
                    userId: userId,
                    tokenProvider: new TokenProvider({
                        url: '/authenticate_user',
                    })
                });
                
                chatManager.connect()
                    .then(connectedUser => {
                        currentUser = connectedUser
                         
                        this.userId = userId;
                        // Get rooms
                        this.getRooms();
                        this.authenticated = true;
                    })
                    .catch(err => {
                        console.log('Error on connection', err)
                    })
            },

            getRooms() {
                fetch(`/get_rooms`)
                    .then( (response) => {
                        return response.json();
                    })
                    .then( (response) => {
                        if (response.status == 200) {
                            this.rooms = response.body;
                        }
                    });
            },

            joinRoom(roomId) {
                currentUser.joinRoom({ roomId: roomId })
                    .then(room => {
                        console.log(`Joined room with ID: ${roomId}`);
                        // Clear the message
                        this.messages = [];
                        this.roomId = roomId;
                    })
                    .catch(err => {
                        console.log(`Error joining room : ${err}`);
                    })
                    
               // Subscribe to the room
                currentUser.subscribeToRoom({
                    roomId: roomId,
                    hooks: {
                        onMessage: message => {
                            console.log(`Received new message ${message}`);
                            // add the current messages state if the message is sent
                            // to the active room
                            if (message.roomId == this.roomId) {
                                this.messages.push(message);
                            }
                        }
                    },
                        messageLimit: 10
                    })
            },

            addMessage(message) {
                currentUser.sendMessage({
                      text: message,
                      roomId: this.roomId
                    })
                    .then(messageId => {
                       console.log(`Added message to`)
                    })
                    .catch(err => {
                        console.log(`Error adding message to: ${err}`)
                    })
            },
        }
    }
</script>

<style> 
  .admin-wrapper {
    display: grid;
    grid-template-columns: 1fr 3fr;
    height: 100vh;
    width: 100vw;
    position: absolute;
    overflow: hidden !important;
   }
</style>