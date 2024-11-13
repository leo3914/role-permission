<template>
<v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="serverItems" :items-length="totalItems" :loading="loading" :search="search" item-value="name" @update:options="loadItems">
    <template v-slot:top>
        <tr>
            <td>
                <v-text-field v-model="search" class="ma-2" density="compact" placeholder="Search name..." @input="onSearch" clearable hide-details></v-text-field>
            </td>
        </tr>
    </template>
</v-data-table-server>
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        itemsPerPage: 10,
        headers: [{
                title: 'Name',
                key: 'name',
                align: 'start'
            },
            {
                title: 'Email',
                key: 'email',
                align: 'start'
            },
            {
                title: 'Phone',
                key: 'phone',
                align: 'start'
            },
            {
                title: 'role',
                key: 'role.role',
                align: 'start'
            },
            // { title: 'Website', key: 'website', align: 'start' }
        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
    }),
    methods: {
        loadItems({
            page,
            itemsPerPage,
        }) {
            this.loading = true;

            // const start = (page-1) * itemsPerPage;
            // const end = start + itemsPerPage;

            axios.get('http://127.0.0.1:8000/api/usersPage', {
                    params: {
                        page: page,
                        per_page:itemsPerPage,
                        search:this.search,
                    }
                })
                .then(res => {
                    // const paginatedUsers = res.data.users.data;
                    // console.log(res.data.users.total);

                    this.serverItems = res.data.users.data;
                    this.totalItems = res.data.users.total;
                    // this.itemsPerPage = res.data.users.per_page;
                    this.loading = false;
                })
                .catch(error => {
                    console.log("Error :", error);
                    this.loading = false;
                });
        },
        onSearch(){
            this.loadItems({page:1, itemsPerPage:this.itemsPerPage});
        },
    },
    created() {
        this.loadItems({
            page: 1,
            itemsPerPage: this.itemsPerPage
        });
    }
}
</script>
