<template>
    <div class="chat-container">
        <div class="head" v-on:click="displayChatArea=!displayChatArea">
           <div style="justify-self: center;">
              Chatx
           </div>
        </div>
         <div v-if="displayChatArea">
            <login
               v-if="!authenticated" 
               v-on:authenticated="setAuthenticated" 
            />
            <messages 
              v-else 
              v-on:new-message="addMessage"
              :messages="messages"
              :userId="userId"
            />
        </div>
    </div>
</template>

<script>
    import Messages from './client/Messages.vue';
    import Login from './client/Login.vue';
    import Key from '../../../config.js';
    
    import { ChatManager, TokenProvider } from '@pusher/chatkit-client';
    
    let currentUser = null;
    
    export default {
        components: {
           Messages,
           Login
        },
        data: function () {
            return {
              authenticated: false,
              roomId: "",
              messages: [],
              userId: "",
              displayChatArea: false
            }
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
                        // create a new room
                        this.createRoom(userId);
                    })
                    .catch(err => {
                        console.log('Error on connection', err)
                    })
            },

            createRoom(roomName) {
                fetch(`/create_room`, {
                    method: "POST",
                    body: `room_name=${roomName}&user_id=${this.userId}`,
                    headers: {'Content-Type':'application/x-www-form-urlencoded'},
                })
                    .then( (response) => {
                        return response.json();
                    })
                    .then( (response) => {
                        if (response.status == 201) {
                        
                            this.roomId = response.body.id;
                            this.authenticated = true;
                            
                            currentUser.joinRoom({ roomId: this.roomId })
                                .then(room => {
                                    console.log(`Joined room with ID: ${room.id}`)
                                })
                                .catch(err => {
                                    console.log(`Error joining room : ${err}`)
                                })
                                
                            // Subscribe to the room
                            currentUser.subscribeToRoom({
                                roomId: this.roomId,
                                hooks: {
                                    onMessage: message => {
                                        console.log(`Received new message ${message}`);
                                        this.messages.push(message);
                                    }
                                },
                                    messageLimit: 10
                                })
                        }
                    });
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
  .chat-container {
    position: fixed; 
    left: 0px; 
    bottom: 0px; 
    width: 400px; 
    z-index: 100000; 
    box-sizing: border-box;
  }
  .head {
    padding: 9px; 
    display: grid; 
    background-color: rgb(48, 13, 79); 
    color: white; 
    border-top-left-radius: 5px; 
    border-top-right-radius: 5px;
  }
  .chat-box {
    border-left: 1px solid rgb(48, 13, 79);
    border-right: 1px solid rgb(48, 13, 79);
    background: lightgray;
   }
</style>