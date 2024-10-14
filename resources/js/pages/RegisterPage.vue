<template>
<div class="container mt-5">
    <div class="row justify-content-center align-items-center h-100">
        <div style="width: 400px;" class=" p-4 border shadow-lg rounded">
            <h3 class="text-center mb-4">Register</h3>
            <div v-if="errors" class="alert alert-danger text-center mt-3">
                <div v-if="message">
                    {{ message }}
                </div>
                <div v-for="(error,index) in errors" :key="index">
                    {{ error }}
                </div>
            </div>
            <form @submit.prevent="registerUser">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input v-model="name" type="text" class="form-control" id="name" placeholder="Enter your Name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input v-model="phone" type="number" class="form-control" id="phone" placeholder="Enter your phone">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input v-model="password" type="password" class="form-control" id="password" placeholder="Enter your password">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
            <p class=" text-center">
                Do you have an account. Please <router-link to="/">Login.</router-link>
            </p>
        </div>
    </div>
</div>
</template>

<script>
import api from '../api/axios';

export default {
    name: "RegisterPage",
    data() {
        return {
            name: '',
            email: '',
            phone: '',
            password: '',
            errors: null,
            message: null,
        };
    },
    methods: {
        async registerUser() {
            try {
                this.errors = null;

                const response = await api.post('register', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    password: this.password,
                });

                this.clearForm;

                alert(response.data.message);
                this.$router.push('/');
                // console.log(response);
            } catch (error) {
                // this.message = response.data.message;

                this.errors = error.response.data.errors;
                this.message = error.response.data.message;

                // console.log(error.response.data.message);
                // console.log(error.response.data.errors);
            }
        },
        clearForm() {
            this.name = '';
            this.email = '';
            this.password = '';
            this.phone = '';
        },
    },
}
</script>
