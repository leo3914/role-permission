<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | Done Task
    <hr>
    <h3 class="text-center">Done Task</h3>
    <table class="table table-striped p-2">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
                <th scope="col">Tasks</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="isLoading">
                <td colspan="100" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone }}</td>
                <td>
                    {{ user.role.role }}
                </td>
                <td>
                    <!-- <table class=" table-striped table-sm table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Task</th>
                            <th>Deadline</th>
                            <th>Done</th>
                        </tr>

                        <tr v-for="task in user.tasks" :key="task.id">
                            <td>{{ task.id }}</td>
                            <td>{{ task.task }}</td>
                            <td>{{ task.deadline }}</td>
                            <td>{{ task.done == 0 ? "False" : "True" }}</td>
                        </tr>
                    </table> -->
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
import api from '../../api/axios';

export default {
    name: "DoneTaskComponent",
    data() {
        return {
            users: null,
            isLoading: true,
            token : localStorage.getItem('token'),
        }
    },
    methods: {
        async doneTask() {
            try {
                const res = await api.get('/tasks', {
                    headers: {
                        Authorization: `Bearer ${this.token} `,
                    }
                });
                this.users = res.data.users;
                this.isLoading = false;
                console.log(res.data);
            } catch (e) {
                console.log(e.message);
            }
        }
    },
    mounted() {
        this.doneTask();
    },
}
</script>
