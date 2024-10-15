import api from "../../api/axios";

export default {
    state: {
        roles: [],
        error: null,
        permissions: [],
    },
    getters: {
        roles(state) {
            return state.roles;
        },
        permissions(state) {
            return state.permissions;
        },
    },
    mutations: {
        setRoles(state, roles) {
            state.roles = roles;
        },
        updateData(state, role) {
            state.roles.push(role);
        },
        setPermission(state, permissions) {
            state.permissions = permissions;
        },
    },
    actions: {
        async getRoles({ commit }) {
            try {
                const { data } = await api.get("/roles");
                // console.log(data);
                commit("setRoles", data.roles);
            } catch (e) {
                console.error(e.message);
            }
        },
        async createRole({ commit }, role) {
            try {
                const res = await api.post("/roles", {
                    role: role,
                });
                console.log(res);
                commit("updateData", res.data.role);
            } catch (error) {
                console.log(error.message);
            }
        },
        async getPermissions({ commit }) {
            try {
                const { data } = await api.get("/permissions");
                console.log(data.permissions);
                commit("setPermission", data.permissions);
            } catch (error) {
                console.log(error);
            }
        },
    },
};
