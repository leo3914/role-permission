<template>
<h2 class="text-center">Dashboard</h2>
<h6 class="text-center text-primary">
    {{ userName }}
    <span class="text-secondary">({{ userRole }})</span>
</h6>
<div class="list-group">
    <router-link to="/dashboard" class="list-group-item list-group-item-action">
        Home
    </router-link>
    <router-link v-if="hasPermission('user-create')" to="/dashboard/create" class="list-group-item list-group-item-action">
        Create User
    </router-link>
    <router-link v-if="userRole == 'Admin'" to="/dashboard/role" class="list-group-item list-group-item-action">Role Create</router-link>
    <router-link v-if="hasPermission('task-create')" to="/dashboard/createTask" class="list-group-item list-group-item-action">Create Task</router-link>
    <router-link to="/dashboard/task" class="list-group-item list-group-item-action">Tasks</router-link>
    <router-link to="/dashboard/profile" class="list-group-item list-group-item-action">Profile</router-link>
    <button @click="logout" class="list-group-item list-group-item-action">Logout</button>
</div>
</template>

<script>
export default {
    name: "NavComponent",
    data() {
        return {
            user: null,
        }
    },
    props: {
        userName: String,
        userRole: String,
        hasPermission: Function,
    },
    methods: {
        logout() {
            localStorage.removeItem('token');
            localStorage.clear();
            // this.isLoggedIn = false;
            this.$router.push('/');
        }
    },
    mounted() {}
}
</script>
