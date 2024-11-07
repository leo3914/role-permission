<template>
<div class="my-3 w-100">
        <hr>
        <span class=" h5">Dashboard</span> | Create user
        <hr>
    <h3 class="text-center">Create user</h3>
    <v-row class=" p-2 justify-center">
        <v-form @submit.prevent="clearForm" style="width: 600px;">
            <div v-if="errors" class="alert alert-danger text-center mt-3">
                <div v-for="(error,index) in errors" :key="index">
                    {{ error }}
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input v-model="newUser.name" type="text" class="form-control" id="name" placeholder="Name" />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input v-model="newUser.email" type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input v-model="newUser.phone" type="number" class="form-control" id="phone" placeholder="Phone">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" class="form-select" v-model="newUser.role_id">
                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.role }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input v-model="newUser.password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="d-grid">
                <button @click="createUser(newUser)" class="btn btn-primary">Create</button>
            </div>
        </v-form>
    </v-row>
</div>
</template>

<script>
import {
    mapGetters
} from 'vuex';
import api from '../../api/axios';
import Roles from '../../store/modules/Roles';
import {
    mapActions
} from 'vuex/dist/vuex.cjs.js';

export default {
    name: "CreateComponent",
    data() {
        return {
            newUser: {
                name: "",
                email: "",
                phone: "",
                password: "",
                role_id: null,
                token: localStorage.getItem("token"),
            },
            token: localStorage.getItem("token"),
            errors: null,
            message: null,
        }
    },
    computed: {
        ...mapGetters(["roles"])
    },
    methods: {
        clearForm() {
            this.newUser.name = '';
            this.newUser.email = '';
            this.newUser.password = '';
            this.newUser.phone = '';
            this.newUser.role_id = null;
        },
        ...mapActions(["getRoles", "createUser"]),
    },
    mounted() {
        this.getRoles(this.token);
    },
}
</script>
