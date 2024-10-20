<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | User Lists
    <hr>
    <h3 class="text-center">User Lists</h3>
    <div v-if="!hasPermission('user-read')">
        <div class="text-center alert alert-danger">
            <h3>You haven't permissions :3</h3>
        </div>
    </div>
    <table v-if="hasPermission('user-read')" class="table table-striped p-2">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
                <th scope="col">Permissions</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="isLoading">
                <td colspan="100" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
            <tr v-for=" user in users" :key="user.id" :class="loginUser.id == user.id ? 'table-danger': ''">
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone }}</td>
                <td>
                    {{ user.role.role }}
                </td>
                <td>
                    <span>
                        <span v-for="permission in user.role.permissions" :key="permission.id" :class="badge(permission.name)" class="badge m-1">
                            {{ permission.name }}
                        </span>
                    </span>
                </td>
                <td>
                    <button v-if="loginUser.id !== user.id && hasPermission('user-update')" @click="editUser(user.id)" class="btn btn-outline-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button v-if="loginUser.id !== user.id && hasPermission('user-delete')" @click="deleteUser(user.id)" class="btn btn-outline-danger btn-sm">Delete</button>
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
                <input type="hidden" v-model="user.id" />
                <h6>Name :</h6><input type="text" v-model="user.name" class="form-control mb-1">
                <h6>Phone :</h6><input type="number" v-model="user.phone" class="form-control mb-1">
                <h6>Role : {{ user.role }}</h6>
                <h6>Permissions</h6>
                <div class="form-check col-4 m-1" v-for="permission in permissions" :key="permission.id">
                    <input :checked="user.userPermissions.includes(permission.id)" v-model="user.updatePermissions" class="form-check-input" type="checkbox" :value="permission.id" :id="'permission_' + permission.id">
                    <label class="form-check-label text-primary" :for="'permission_' + permission.id">
                        {{ permission.name.toUpperCase() }}
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button @click="updateUser(user)" class="btn btn-outline-primary">Update</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';
import api from '../../api/axios';
import fetchUser from '../../api/userApi';
import Roles from '../../store/modules/Roles';

export default {
    name: "AllUserComponent",
    data() {
        return {
            user: {
                name: "",
                phone: "",
                id: "",
                role: "",
                userPermissions: [],
                updatePermissions: [],
                token: localStorage.getItem('token'),
            },
            loginUserId: localStorage.getItem('role_id'),
            token: localStorage.getItem('token'),
        }
    },
    props: {
        userRole: String,
        loginUser: Object,
        hasPermission: Function,
    },
    computed: {
        ...mapGetters(["users", "isLoading", "roles", "permissions"]),
    },
    methods: {
        editUser(id) {
            const findUser = this.users.find((i) => i.id == id);
            this.user.id = findUser.id;
            this.user.phone = findUser.phone;
            this.user.name = findUser.name;
            this.user.role_id = findUser.role_id;
            this.user.role = findUser.role.role;
            this.user.updatePermissions = findUser.role.permissions.map(permission => permission.id);
            this.user.userPermissions = findUser.role.permissions.map(permission => permission.id);
            this.getRoles(this.token);
            this.getPermissions(this.token);
        },
        badge(permissionName) {
            switch (permissionName) {
                case 'user-read':
                    return 'text-bg-info';
                case 'user-create':
                    return 'text-bg-primary';
                case 'user-update':
                    return 'text-bg-secondary';
                case 'user-delete':
                    return 'text-bg-danger';
                default:
                    return 'text-bg-light';
            }
        },
        ...mapActions(['getUsers', 'getRoles', 'updateUser', "getPermissions", "updateUser", "deleteUser"]),
    },
    mounted() {
        this.getUsers(this.token);
    },
}
</script>
