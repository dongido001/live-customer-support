<template> 
    <div class="message-area">
        <div id="messages">
            <div
                class="chat-message" 
                v-for="message in messages" 
                v-bind:key="message.id"
                v-bind:class="[(message.senderId != userId) ? 'from-client' : 'from-admin']"
            >
                {{ message.text }}
            </div>            
        </div>
    
        <div class="fix-to-bottom">
            <input 
              type="text" 
              class="chat-input" 
              placeholder="enter message..."
              v-model="message"
              v-on:keyup.enter="addMessage"
            >
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            messages: Array,
            userId: String
        },
        data() {
            return {
                message: ""
            }
        },
        methods: {
            addMessage() {
                this.$emit('new-message', this.message);
                this.message = "";
            }
        }
    }
</script>

<style>
   .fix-to-bottom {
       margin: 0px; 
       bottom: 0; 
       top: auto; 
       position: fixed; 
       z-index: 999999; 
       width: 100%;
   }
   .message-area {
     background-color: rgb(211, 211, 202);
   }
  #messages {
    overflow-y: scroll;
    width: 100%;
  }
  .chat-message {
    width: 70%;
    margin-bottom: 8px;
    padding: 5px;
  }
  .from-admin {
    background: rgb(48, 13, 79);
    color: white;
    float: right;
  }
  .from-client {
    background: rgb(191, 202, 204);
    color: rgb(39, 37, 37);
    float: left;
  }
  .chat-input {
      width: 100%; 
      margin-bottom: 0px;
  }
</style>