<template>
<v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="users" :items-length="totalItems" :loading="loading" :search="search" item-value="name">
    <!-- Slot to display user permissions -->
    <template v-slot:[`item.permissions`]="{ item }">
        <td>
            <div v-if="item.role && item.role.permissions && item.role.permissions.length">

                <span v-for="(permission, index) in item.role.permissions" :key="index" class="badge badge-light">
                    {{ permission.name }}
                </span>

            </div>
            <span v-else>No permissions</span>
        </td>
    </template>
    <template v-slot:tfoot>
        <tr>
            <td>
                <v-text-field v-model="name" class="ma-2" density="compact" placeholder="Search name..." hide-details></v-text-field>
            </td>
        </tr>
    </template>
</v-data-table-server>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex'

export default {
    data: () => ({
        itemsPerPage: 5,
        headers: [{
                title: 'Id',
                align: 'start',
                sortable: false,
                key: 'id',
            },
            {
                title: 'name',
                key: 'name',
                align: 'end'
            },
            {
                title: 'Phone',
                key: 'phone',
                align: 'end'
            },
            {
                title: 'Email',
                key: 'email',
                align: 'end'
            },
            {
                title: 'Role',
                key: 'role.role',
                align: 'end'
            },
            {
                title: 'Permissions',
                key: 'permissions',
            },
            {
                title: 'Actions'
            }
        ],
        loading: true,
        totalItems: 0,
        name: '',
        search: '',
        token: localStorage.getItem('token'),
    }),
    watch: {
        name() {
            this.search = String(Date.now())
        },
    },
    methods: {
        ...mapActions(['getUsers']),
        async fetchUsers() {
            this.loading = true;
            try {
                await this.getUsers(this.token);
                this.loading = false;
            } catch (error) {
                console.error("Error fetching users:", error);
                this.loading = false;
            }
        },
    },
    computed: {
        ...mapGetters(['users']),
    },
    mounted() {
        this.fetchUsers();
        // console.log(this.users);
    },
}
</script>
