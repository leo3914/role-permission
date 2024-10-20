<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-2">
            <NavComponent :userName="userName" :userRole="userRole" />
        </div>
        <div class="col-md-10">
            <!-- <router-view :users="users" :fetchUsers="fetchUsers" /> -->
            <router-view :loginUser="loginUser" />
        </div>
    </div>
</div>
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
            // users: [],
            userRole: null,
            loginUser : JSON.parse(localStorage.getItem("user")),
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
                // console.log(data);
                // console.log(this.users);
            } catch (e) {
                console.log(e.message);
            }
        }
    },
    mounted() {
        const loginUser = JSON.parse(localStorage.getItem("user"));
        console.log(loginUser);
        // this.fetchUsers();
        // if (localStorage.getItem('token')) {
        //     this.fetchUsers();
        // }
        // console.log(JSON.parse(localStorage.getItem('user')));
        // console.log(localStorage.getItem('user'));

        const user = localStorage.getItem('user');
        if (user) {
            this.user = JSON.parse(user);
            this.userName = this.user.name;
            this.userRole = this.user.role.role;
        };
        // console.log(this.loginPermissions);
    }
}
</script>
