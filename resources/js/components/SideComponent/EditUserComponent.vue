<template>
<div class="my-3">
    <hr>
    <span class="h5">Dashboard</span> | User Lists | <span class="h6">Edit</span>
    <hr>
    <h3 class="text-center">Edit User {{ $route.params.id }}</h3>
    <form>

    </form>

</div>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';

export default {
    name: "EditUserComponent",
    data() {
        return {
            id: this.$route.params.id,
            // user:[],
        }
    },
    computed: {
        ...mapGetters(['users','user'])
    },
    methods: {
        ...mapActions(['getUserId'])
    },
    mounted() {
        console.log(this.users);
        this.getUserId(this.id)
        console.log(this.user);
    },
}
</script>
