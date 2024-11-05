<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-2">
            <NavComponent :userName="userName" :userRole="userRole" :hasPermission="hasPermission" />
        </div>
        <div class="col-md-10">
            <!-- <router-view :users="users" :fetchUsers="fetchUsers" /> -->
            <router-view :loginUser="loginUser" :hasPermission="hasPermission" />
        </div>
    </div>
</div>
<v-btn>Button</v-btn>
</template>

<script>
import axios from 'axios';
import NavComponent from '../../components/NavComponent/NavComponent.vue';
import api from '../../api/axios';

export default {
    components: {
        NavComponent,
    },
    name: "DashboardPage",
    data() {
        return {
            user: null,
            userName: "",
            userRole: null,
            loginUser : JSON.parse(localStorage.getItem("user")),
            loginPermissions: JSON.parse(localStorage.getItem('permissions')),
        }
    },
    computed: {
        userPermissions() {
            return JSON.parse(this.loginPermissions || []);
        }
    },
    methods: {
        async fetchUsers() {
            try {
                const res = await api.get('/users');
                const data = res.data.users;
                this.users = data;
            } catch (e) {
                console.log(e.message);
            }
        },
        hasPermission(permission) {
            return this.loginPermissions.find(el => el.name == permission);
        },
    },
    mounted() {
        const loginUser = JSON.parse(localStorage.getItem("user"));

        const user = localStorage.getItem('user');
        if (user) {
            this.user = JSON.parse(user);
            this.userName = this.user.name;
            this.userRole = this.user.role.role;
        };
    }
}
</script>
