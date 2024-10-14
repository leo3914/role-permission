<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | Create user
    <hr>
    <h3 class="text-center">Create user</h3>
    <div class="container">
        <div class="row justify-content-center align-items-center h-100">
            <form @submit.prevent="createUser" style="width: 600px;">
                <div v-if="errors" class="alert alert-danger text-center mt-3">
                    <div v-for="(error,index) in errors" :key="index">
                        {{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input v-model="name" type="text" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input v-model="email" type="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input v-model="phone" type="number" class="form-control" id="phone" placeholder="Phone">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" class="form-select" v-model="role_id">
                        <option value="1">Admin</option>
                        <option value="2">Manager</option>
                        <option value="3">User</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input v-model="password" type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import api from '../../api/axios';

export default {
    name: "CreateComponent",
    data() {
        return {
            name: "",
            email: "",
            phone: "",
            password: "",
            role_id : null,
            errors: null,
            message: null,
        }
    },
    props: {
        // fetchUsers :{
        //     type : Function,
        // },
    },
    methods: {
        async createUser() {
            try {
                this.errors = null;
                const response = await api.post('/users', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    role_id : this.role_id,
                    password: this.password,
                });

                this.clearForm();
                // alert(response);
                // console.log(response);
                // this.fetchUsers();
                // this.$route('/dashboard');
                alert("Create user successfully");
            } catch (error) {
                this.message = error.response.data.message;
                this.errors = error.response.data.errors;
                alert(this.message);
            }
        },
        clearForm() {
            this.name = '';
            this.email = '';
            this.password = '';
            this.phone = '';
            this.role_id = null;
        },
    },
}
</script>
