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
        async getRoles({ commit }, token) {
            try {
                const { data } = await api.get("/roles", {
                    headers: {
                        Authorization: `Bearer ${token} `,
                    },
                });
                // console.log(data);
                commit("setRoles", data.roles);
            } catch (e) {
                console.error(e.message);
            }
        },
        async createRole({ commit }, newRole) {
            try {
                const { data } = await api.post(
                    "/role-permission",
                    {
                        role: newRole.role,
                        permissions: newRole.selectPermissions,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${newRole.token} `,
                        },
                    }
                );
                commit("updateData",data.role);
            } catch (error) {
                console.log(error.message);
            }
        },
        async getPermissions({ commit }, token) {
            try {
                const { data } = await api.get("/permissions", {
                    headers: {
                        Authorization: `Bearer ${token} `,
                    },
                });
                // console.log(data.permissions);
                commit("setPermission", data.permissions);
            } catch (error) {
                console.log(error);
            }
        },
    },
};
