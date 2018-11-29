
<template>
    <div class="login-wrapper">
        <div class="login-form">
            <input type="text" placeholder="Enter your username" v-model="username">
             <input type="text" placeholder="Enter your password" v-model="password">
            <button type="submit" class="submit" v-on:click="login"> Submit </button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
              name: this.username,
              username: "",
              password: "",
            }
        },
        methods: {
            login: function() {
                // TODO: Authenticate the admin
                
                fetch('/create_user', {
                    method: "POST",
                    body: `name=${this.name}&user_id=${this.username}`,
                    headers: {'Content-Type':'application/x-www-form-urlencoded'},
                })
                    .then( (response) => {
                        return response.json();
                    })
                    .then( (response) => {
                        fetch(`/authenticate_user?user_id=${this.username}`, {
                            method: "POST",
                            headers: {'Content-Type':'application/x-www-form-urlencoded'},
                        })
                            .then( (response) => {
                                return response.json();
                            })
                            .then( (response) => {
                                this.$emit("authenticated", this.username);
                            });
                    });
            }
        }
    }
</script>

<style scoped> 
    input[type="text"] {
        padding: 10px 8px;
        margin-bottom: 5px;
        border-radius: 4px;
        font-size: 16px;
        font-size: 16px;
        border: 1px solid darkgray;
    }
    .submit {
        margin-top: 9px;
        padding: 20px;
        background: rgb(99, 99, 212);
        color: white;
        font-size: 16px;
        border-radius: 4px;
    }
    .login-wrapper {
        width: 500px;
        border: 1px solid #cccccc;
        background-color: #ffffff;
        margin: auto;
        margin-top: 200px;
        padding: 20px;
    }
    .login-form {
        display: grid; 
        height: 100%;
        overflow: hidden !important;
    }
</style>