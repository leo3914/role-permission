<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | Create Role
    <hr>
    <h3 class="text-center mb-3">Roles</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4 border p-4 rounded">
                <h5 class="mb-3">Create Role</h5>
                <form @submit.prevent="clearForm()">
                    <input type="text" class="form-control mb-2" placeholder="Enter role" v-model="newRole.role">
                    <div class="row">
                        <div class="form-check col-4 m-1" v-for="permission in permissions" :key="permission.id">
                            <input v-model="newRole.selectPermissions" class="form-check-input" type="checkbox" :value="permission.id" :id="'permission_' + permission.id">
                            <label class="form-check-label text-primary" :for="'permission_' + permission.id">
                                {{ permission.name.toUpperCase() }}
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2" @click="createRole(newRole)">Create Role</button>
                </form>
            </div>
            <div class="col-md-8">
                <h5 class="mb-3">Role List</h5>
                <table class=" table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in roles" :key="role.id">
                            <td>{{ role.id }}</td>
                            <td>{{ role.role }}</td>
                            <td>
                                <span>
                                    <span v-for="permission in role.permissions" :key="permission.id" :class="badge(permission.name)" class="badge text-bg-primary m-1">{{ permission.name }}</span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    createPopperLite
} from '@popperjs/core';
import {
    mapActions,
    mapGetters
} from 'vuex'
export default {
    name: "RoleComponent",
    data() {
        return {
            token: localStorage.getItem('token'),
            newRole: {
                token: localStorage.getItem('token'),
                role: "",
                selectPermissions: [],
            },
        }
    },
    methods: {
        clearForm() {
            this.newRole.role = "";
            this.newRole.selectPermissions = [];
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
                case 'task-create':
                    return 'text-bg-success';
                case 'task-read':
                    return 'text-bg-light';
                case 'task-update':
                    return 'text-bg-dark';
                case 'task-delete':
                    return 'text-bg-warning';
                default:
                    return 'text-bg-light';
            }
        },
        ...mapActions(['getRoles', 'createRole', 'getPermissions']),
    },
    computed: {
        ...mapGetters(['roles', 'permissions']),
    },
    mounted() {
        this.getRoles(this.token);
        this.getPermissions(this.token);
    },
}
</script>
