<template>
<div class="container">
    <div class="row justify-center items-center">
        <div class="mt-4">
            <h1>Profile</h1>
            <h4>Name : <span class="text-primary">{{ user.name }}</span></h4>
            <h4>Email : <span class="text-primary">{{ user.email }}</span></h4>
            <h4>Phone : <span class="text-primary">{{ user.phone }}</span></h4>
            <h4>Role : <span class="text-primary">{{ user.role_id && 'User' }}</span></h4>
            <button @click="logout" class="btn btn-primary">Logout</button>
        </div>
    </div>
</div>
</template>

<script>
import api from '../../api/axios';

export default {
    name: "UserPage",
    data() {
        return {
            user: JSON.parse(localStorage.getItem('user')),
        }
    },
    methods: {
        logout() {
            localStorage.removeItem('token');
            localStorage.clear();
            this.$router.push('/');
        }
    },
}
</script>
