<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | User Lists
    <hr>
    <h3 class="text-center">User Lists</h3>
    <table class="table table-striped p-2">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
                <th v-if="loginUserId == 1" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr v-if="isLoading">
                <td colspan="100" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr> -->
            <tr v-for="user in users" :key="user.id">
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone }}</td>
                <td>
                    {{ user.role_id }}
                </td>
                <td>
                    <button v-if="loginUserId == 1" @click="editUser(user.id)" class=" btn btn-outline-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button @click="deleteUser(user.id)" v-if="loginUserId == 1" class=" btn btn-outline-danger btn-sm me-1">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="id" />
                <input type="text" v-model="name" class="form-control mb-1">

                <input type="number" v-model="phone" class="form-control mb-1">
                <select class="form-select" v-model="role_id">
                    <option value="1">Admin</option>
                    <option value="2">Manager</option>
                    <option value="3">User</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button @click="updateUser(id)" class="btn btn-outline-primary">Update</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { mapActions,mapGetters } from 'vuex';
import api from '../../api/axios';
import fetchUser from '../../api/userApi';

export default {
    name: "AllUserComponent",
    data() {
        return {
            name: "",
            phone: "",
            role_id: "",
            id: "",
            loginUserId: localStorage.getItem('role_id'),
            token: localStorage.getItem('token'),
        }
    },
    computed: {
        ...mapGetters(["users"]),
    },
    methods: {
        editUser(id) {
            const user = this.users.find((i) => i.id == id);
            // console.log(user);
            this.id = user.id;
            this.phone = user.phone;
            this.name = user.name;
            this.role_id = user.role_id;
        },
        async updateUser(id) {
            try {
                const res = await api.put(`/users/${id}`, {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    role_id: this.role_id,
                });
                this.name = "";
                this.phone = "",
                    this.role_id = "";
                this.id = "";

                const modal = document.querySelector('[data-bs-dismiss="modal"]');
                if (modal) {
                    modal.click();
                }
                alert(res.data.message);
                this.fetchUsers();
            } catch (e) {
                console.error(e.message);
            }
        },
        async deleteUser(id) {
            try {
                const isConfirmed = confirm("Are you sure you want to delete this user?");

                if (isConfirmed) {
                    const res = await api.delete(`/users/${id}`);
                    alert(res.data.message);
                    this.fetchUsers();
                }
                this.fetchUsers();
            } catch (e) {
                console.error(e.message);
            }
        },
        ...mapActions(['getUsers']),
        async fetchUsers() {
            try {
                const res = await api.get('/users', {
                    headers: {
                        Authorization: `Bearer ${this.token} `,
                    }
                });
                const data = res.data.users;
                this.isLoading = false,
                    this.users = data;
                console.log(res);
                // console.log(this.users);
            } catch (e) {
                console.log(e.message);
            }
        }
    },
    mounted() {
        // this.fetchUsers();
        this.getUsers(this.token);
        console.log(this.users);
    },
}
</script>
