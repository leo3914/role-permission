<template>
<div class="my-3">
    <hr>
    <span class=" h5">Dashboard</span> | Create Task
    <hr>
    <h3 class="text-center">Create Task</h3>
    <div class="container">
        <div class="row justify-content-center align-items-center h-100">
            <form @submit.prevent="clearForm()" style="width: 600px;">
                <label for="task" class="mb-1">Task</label>
                <input v-model="task.task" type="text" id="task" class="form-control mb-1" placeholder="Enter a task">

                <label for="u" class="mb-1">Select a user</label>
                <select v-model="task.user_id" id="u" class="form-select mb-1">
                    <option>Select a user</option>
                    <option v-for="user in users" :value="user.id" :key="user.id">{{ user.name }}</option>
                </select>

                <label for="deadline" class="mb-1">Deadline</label>
                <input v-model="task.deadline" type="date" id="deadline" class=" form-control mb-1">

                <button @click="createTask(task)" class="btn btn-primary">Create</button>
            </form>
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
    name: "CreateTaskComponent",
    data() {
        return {
            task: {
                task: "",
                user_id: "",
                deadline: "",
                token: localStorage.getItem("token"),
            },
        }
    },
    computed: mapGetters(['users']),
    methods: {
        ...mapActions(["createTask"]),
        clearForm() {
            this.task.task = "";
            this.task.user_id = "";
            this.task.deadline = "";
        },
        // async createTask() {
        //     try {
        //         const res = await api.post('/tasks', {
        //             task: this.task,
        //             deadline: this.deadline,
        //             user_id: this.user_id
        //         });
        //         // console.log(res);
        //         this.task = "";
        //         this.user_id = "";
        //         this.deadline = "";
        //         alert(res.data.message);
        //     } catch (e) {
        //         console.log(e.message);
        //     }
        // },
        // async fetchUsers() {
        //     try {
        //         const res = await api.get('/users');
        //         const data = res.data.users;
        //         this.users = data;
        //         // console.log(data);
        //         // console.log(this.users);
        //     } catch (e) {
        //         console.log(e.message);
        //     }
        // }
    },
    mounted() {},
}
</script>
