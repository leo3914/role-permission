import api from "../../api/axios";

export default {
    state: {
        tasks: [],
    },
    getters: {
        tasks(state) {
            return state.tasks;
        },
    },
    mutations: {
        setTasks(state, tasks) {
            state.tasks = tasks;
        },
        createTasks(state, task) {
            state.tasks.push(task);
        },
        updateTasks(state, newTask) {
            state.tasks = state.tasks.map((task) => {
                if (task.id === newTask.id) {
                    return newTask;
                }
                return task;
            });
        },
        delTask(state, id) {
            state.tasks = state.tasks.filter((task) => task.id !== id);
        },
    },
    actions: {
        async createTask({ commit }, task) {
            try {
                const { data } = await api.post(
                    "/tasks",
                    {
                        task: task.task,
                        deadline: task.deadline,
                        user_id: task.user_id,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${task.token}`,
                        },
                    }
                );
                commit("createTasks", data.task);
                alert(data.message);
            } catch (e) {
                console.log(e.message);
            }
        },
        async getTasks({ commit }, token) {
            try {
                const { data } = await api.get("/tasks", {
                    headers: {
                        Authorization: `Bearer ${token} `,
                    },
                });
                commit("setTasks", data.tasks);
            } catch (e) {
                console.log(e.message);
            }
        },
        async updateTask({ commit }, task) {
            try {
                const { data } = await api.put(
                    `/tasks/${task.id}`,
                    {
                        task: task.task,
                        deadline: task.deadline,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${task.token} `,
                        },
                    }
                );
                const modal = document.querySelector(
                    '[data-bs-dismiss="modal"]'
                );
                if (modal) {
                    modal.click();
                }
                commit("updateTasks", data.task);
                alert(data.message);
                // console.log(res);
            } catch (error) {
                console.log(error.message);
            }
        },
        async deleteTask({ commit }, id) {
            try {
                const isConfirmed = confirm(
                    "Are you sure want to delete task?"
                );

                if (isConfirmed) {
                    const res = await api.delete(`/tasks/${id}`);
                    alert(res.data.message);
                    commit("delTask", id);
                }
            } catch (error) {}
        },
    },
};
