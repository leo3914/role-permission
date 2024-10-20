import api from "../../api/axios";

export default {
    state: {
        users: [],
        isLoading: true,
        error: null,
        user: [],
    },
    getters: {
        users(state) {
            return state.users;
        },
        isLoading(state) {
            return state.isLoading;
        },
        user(state) {
            return state.user;
        },
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
        setUser(state, user) {
            state.user = user;
        },
        setLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setError(state, error) {
            state.error = error;
        },
        updateUsers(state, newUser) {
            state.users = state.users.map((user) => {
                if (user.id === newUser.id) {
                    return newUser;
                }
                return user;
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
        async createUser({ commit }, newUser) {
            try {
                this.errors = null;
                const { data } = await api.post(
                    "/users",
                    {
                        name: newUser.name,
                        email: newUser.email,
                        phone: newUser.phone,
                        password: newUser.password,
                        role_id: newUser.role_id,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${newUser.token}`,
                        },
                    }
                );
                alert(data.message);
            } catch (error) {
                alert(error.message);
            }
        },
        async updateUser({ commit }, user) {
            try {
                const { data } = await api.put(
                    `/users/${user.id}`,
                    {
                        name: user.name,
                        phone: user.phone,
                        permissions: user.updatePermissions,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${user.token}`,
                        },
                    }
                );
                const modal = document.querySelector(
                    '[data-bs-dismiss="modal"]'
                );
                if (modal) {
                    modal.click();
                }
                alert(data.message);
                commit("updateUsers", data.user);
            } catch (e) {
                console.error(e.message);
            }
        },
        async getUserId({ commit }, id) {
            try {
                const { data } = await api.get(`/users/${id}`);
                console.log(user);
                commit("setUser", data.user);
            } catch (error) {
                console.log(error.message);
            }
        },
    },
};
