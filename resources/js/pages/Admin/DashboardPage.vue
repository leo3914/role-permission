<template>
<v-layout class="rounded rounded-md">
    <!-- <div class="row"> -->
    <v-navigation-drawer>
        <NavComponent :userName="userName" :userRole="userRole" :hasPermission="hasPermission" />
    </v-navigation-drawer>
    <v-main class="d-flex align-center justify-center">
        <div class="p-2">
            <router-view :loginUser="loginUser" :hasPermission="hasPermission" />
        </div>
    </v-main>
    <!-- </div> -->
</v-layout>
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
            loginUser: JSON.parse(localStorage.getItem("user")),
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
