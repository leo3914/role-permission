<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | Profile
    <hr>
    <h3 class="text-center">Profile</h3>
    <div class="row justify-center items-center">
        <div class="mt-4">
            <h1>Profile</h1>
            <h4>Name : <span class="text-primary">{{ user.name }}</span></h4>
            <h4>Email : <span class="text-primary">{{ user.email }}</span></h4>
            <h4>Phone : <span class="text-primary">{{ user.phone }}</span></h4>
            <h4>Role : <span v-if="user.role_id == 1" class="text-primary">Admin</span>
                <span v-else-if="user.role_id == 2" class="text-primary">Manager</span>
                <span v-else class="text-primary">User</span></h4>
            <button @click="logout" class="btn btn-primary">Logout</button>
        </div>
    </div>
    <form action="">
    </form>
</div>
</template>

<script>
export default {
    name: "ProfileComponent",
    data() {
        return {
            user: JSON.parse(localStorage.getItem('user')),
        }
    },
}
</script>
