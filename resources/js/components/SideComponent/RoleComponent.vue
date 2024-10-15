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
                <form @submit.prevent="clearForm">
                    <input type="text" class="form-control mb-2" placeholder="Enter role" v-model="role">
                    <div class="row">
                        <div class="form-check col-4 m-1" v-for="permission in permissions" :key="permission.id">
                            <input class="form-check-input" type="checkbox" :value="permission.id" :id="'permission_' + permission.id">
                            <label class="form-check-label" :for="'permission_' + permission.id">
                                {{ permission.name.toUpperCase() }}
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2" @click="createRole(role)">Create Role</button>
                </form>
            </div>
            <div class="col-md-8">
                <h5 class="mb-3">Role List</h5>
                <table class=" table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="role in roles" :key="role.id">
                        <td>{{ role.id }}</td>
                        <td>{{ role.role }}</td>
                        <td>
                        </td>
                    </tr>
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
            role: ""
        }
    },
    methods: {
        clearForm() {
            this.role = "";
        },
        ...mapActions(['getRoles', 'createRole', 'getPermissions']),
    },
    computed: {
        ...mapGetters(['roles', 'permissions']),
    },
    mounted() {
        this.getRoles();
        this.getPermissions();
        // this.createRole(this.role);
        console.log(this.roles);
    },
}
</script>
