import api from "../../api/axios";

export default {
    state: {
        users: [],
        isLoading: true,
        error: null,
    },
    getters: {
        users(state) {
            return state.users;
        },
        isLoading(state) {
            return state.isLoading;
        },
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
        setLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setError(state, error) {
            state.error = error;
        },
        updateUsers(state, user) {
            state.users.forEach((el, index) => {
                if (el.id === updatedUser.id) {
                    state.users = [...el, ...updatedUser];
                }
            });
        },
    },
    actions: {
        async getUsers({ commit }, token) {
            try {
                const { data } = await api.get("/users", {
                    headers: {
                        Authorization: `Bearer ${token} `,
                    },
                });
                commit("setUsers", data.users);
                commit("setLoading", false);
                // console.log(data);
                // console.log(this.users);
            } catch (e) {
                commit("setLoading", false);
                commit("setError", e.message);
                console.log(e.message);
            }
        },
        async updateUser({ commit }, id, user) {
            try {
                const res = await api.put(`/users/${id}`, user);
                // alert(res.data.message);
                // commit("updateUsers", user);
                console.log(res);
            } catch (e) {
                console.error(e.message);
            }
        },
    },
};
