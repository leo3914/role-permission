<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | Done Task
    <hr>
    <h3 class="text-center">Done Task</h3>
    <div v-if="!hasPermission('task-read')">
        <div class="text-center alert alert-danger">
            <h3>You haven't permissions :3</h3>
        </div>
    </div>
    <v-table v-if="hasPermission('task-read')" class=" p-2">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Task</th>
                <th scope="col">Deadline</th>
                <th scope="col">Done</th>
                <th scope="col">User</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr v-if="isLoading">
                <td colspan="100" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr> -->
            <tr v-for="task in tasks" :key="task.id">
                <td scope="row">{{ task.id }}</td>
                <td>{{ task.task }}</td>
                <td>{{ task.deadline }}</td>
                <td>{{ task.isDone ? 'Done' : 'False' }}</td>
                <td>{{ task.user.name }}</td>
                <td>
                    <button v-if="hasPermission('task-update')" @click="editTask(task.id)" class="btn btn-outline-info btn-sm m-1" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button v-if="hasPermission('task-delete')" @click="deleteTask(task.id)" class="btn btn-outline-danger btn-sm m-1">Delete</button>
                </td>
            </tr>
        </tbody>
    </v-table>

    <!-- EditModal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input v-model="task.id" type="hidden" />
                    <input class="form-control mb-1" v-model="task.task" type="text" />
                    <input class="form-control mb-1" v-model="task.deadline" type="date" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button @click="updateTask(task)" type="button" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';
import api from '../../api/axios';

export default {
    name: "DoneTaskComponent",
    data() {
        return {
            task: {
                id: "",
                task: "",
                deadline: "",
                token: localStorage.getItem('token'),
            },
            isLoading: true,
            token: localStorage.getItem('token'),
        }
    },
    props: {
        hasPermission: Function,
    },
    computed: mapGetters(["tasks"]),
    methods: {
        ...mapActions(["getTasks", "updateTask","deleteTask"]),
        editTask(id) {
            const task = this.tasks.find((i) => i.id == id);
            if (task) {
                this.task.id = task.id;
                this.task.task = task.task;
                this.task.deadline = task.deadline;
            }
        },
    },
    mounted() {
        this.getTasks(this.token);
    },
}
</script>
