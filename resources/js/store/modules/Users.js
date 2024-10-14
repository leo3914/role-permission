import api from "../../api/axios";

export default {
    state: {
        users: [],
        isLoading: false,
        error: null,
    },
    getters: {
        users(state) {
            return state.users;
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
    },
    actions: {
        async getUsers({ commit }, token) {
            try {
                const { data } = await api.get("/users", {
                    headers: {
                        Authorization: `Bearer ${token} `,
                    },
                });
                commit("setUsers", data);
                commit("setLoading", false);
                console.log(data);
                // console.log(this.users);
            } catch (e) {
                commit("setLoading", false);
                console.log(e.message);
            }
        },
    },
};
