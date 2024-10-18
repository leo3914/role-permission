<template>
<div class="container mt-5">
    <div class="row justify-content-center align-items-center h-100">
        <div style="width: 400px;" class=" p-4 border shadow-lg rounded">
            <h3 class="text-center mb-4">Login</h3>
            <div v-if="message" class="alert alert-danger text-center">
                <span>
                    {{ message }}
                </span>
            </div>
            <div v-if="errors" class="alert alert-danger text-center">
                <div v-for="(error,index) in errors" :key="index">
                    {{ error }}
                </div>
            </div>
            <form @submit.prevent="loginUser">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input v-model="password" type="password" class="form-control" id="password" placeholder="Enter your password">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <p class=" text-center">
                Do you haven't an account. Please <router-link to="/register">Register.</router-link>
            </p>
        </div>
    </div>
</div>
</template>

<script>
import api from '../api/axios';

export default {
    name: "LoginPage",
    data() {
        return {
            email: "",
            password: "",
            message: null,
            errors: null,
        }
    },
    methods: {
        async loginUser() {
            try {
                const {data} = await api.post('/login', {
                    email: this.email,
                    password: this.password,
                })
                const user = data.user;
                localStorage.setItem("token",data.token);
                localStorage.setItem("user", JSON.stringify(data.user));
                localStorage.setItem("role", data.role);
                localStorage.setItem("permissions", JSON.stringify(data.permissions));
                this.email = '';
                this.password = '';
                console.log(data);
                console.log(user);
                if (data.token) {
                    console.log("Redirecting to dashboard");
                    this.$router.push('/dashboard');
                } else if (data.permissions == []) {
                    console.log("Redirecting to user page");
                    this.$router.push('/user');
                } else {
                    console.log("Role ID not recognized");
                }
            } catch (error) {
                this.errors = error.response.data.errors;
                this.message = error.response.data.message;
                console.log(error);
            }
        }
    },
}
</script>
