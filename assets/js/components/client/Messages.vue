
<template> 
        <div class="chat-box">
            <div id="messages">
                <div
                    class="chat-message" 
                    v-for="message in messages" 
                    v-bind:key="message.id"
                    v-bind:class="[(message.senderId == userId) ? 'from-client' : 'from-admin']"
                >
                    {{ message.text }}
                </div>
            </div>
           
           <div class="input-container">
             <input
                class="chat-input" 
                type="text" 
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
    .chat-message {
        width: 70%;
        margin-bottom: 8px;
        padding: 5px;
    }
    .from-admin {
        background: rgb(191, 202, 204);
        color: rgb(39, 37, 37);
        float: left;
    }
    .from-client {
        background: rgb(48, 13, 79);
        color: white;
        float: right;
    }
    .input-container {
        margin: 0px;
    }
    .chat-input {
        width: 99%; 
        margin-bottom: 0px;
    }
    #messages {
        overflow-y: scroll; 
        max-height: 320px;
        min-height: 320px;
    }
</style>