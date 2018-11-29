
<template>
    <div class="login-container chat-box">
        <div class="inputs">
            <input type="text" placeholder="your name" v-model="name">
            <input type="text" placeholder="your email" v-model="userId">
        </div>
        <button type="submit" class="submit" v-on:click="login"> Submit </button>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
              name: "",
              userId: "",
              message: ""
            }
        },
        methods: {

            login: function() {
                fetch('/create_user', {
                    method: "POST",
                    body: `name=${this.name}&user_id=${this.userId}`,
                    headers: {'Content-Type':'application/x-www-form-urlencoded'},
                })
                    .then( (response) => {
                        return response.json();
                    })
                    .then( (response) => {
                        fetch(`/authenticate_user?user_id=${this.userId}`, {
                            method: "POST",
                            headers: {'Content-Type':'application/x-www-form-urlencoded'},
                        })
                            .then( (response) => {
                                return response.json();
                            })
                            .then( (response) => {
                                this.$emit("authenticated", this.userId);
                            });
                    });
            }
        }
    }
</script>

<style> 
    .login-container {
        display: grid; 
        grid-template-rows: 4fr 1fr;
        max-height: 320px;
        min-height: 320px;
    }
    input[type="text"] {
        padding: 10px 8px;
        margin-top: 10px;
        border-radius: 2px;
        border: 1px solid darkgray;
        font-size: 16px;
        box-sizing: border-box;
        display: block;
    }
    .inputs {
        text-align: center;
        align-self: center;
        justify-self: center;
    }
    .submit {
        margin-top: 9px;
        padding: 20px;
        background: rgb(99, 99, 212);
        color: white;
        font-size: 16px;
    }
</style>