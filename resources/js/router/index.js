import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/LoginPage.vue";
import RegisterPage from "../pages/RegisterPage.vue";
import DashboardPage from "../pages/Admin/DashboardPage.vue";
import AllUserComponent from "../components/SideComponent/AllUserComponent.vue";
import RoleComponent from "../components/SideComponent/RoleComponent.vue";
import DoneTaskComponent from "../components/SideComponent/DoneTaskComponent.vue";
import ProfileComponent from "../components/SideComponent/ProfileComponent.vue";
import UserPage from "../pages/User/UserPage.vue";
import CreateComponent from "../components/SideComponent/CreateComponent.vue";
import CreateTaskComponent from "../components/SideComponent/CreateTaskComponent.vue";
import EditUserComponent from "../components/SideComponent/EditUserComponent.vue";
import TestComponent from "../components/SideComponent/TestComponent.vue";

const routes = [
    {
        path: "/",
        name: "LoginPage",
        component: LoginPage,
    },
    {
        path: "/register",
        name: "RegisterPage",
        component: RegisterPage,
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: DashboardPage,
        props: true,
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem("token");
            if (token) {
                next();
            } else {
                next("/");
            }
        },
        children: [
            {
                path: "",
                name: "AllUserComponent",
                component: AllUserComponent,
                props: true,
            },
            {
                path: "/dashboard/user/:id",
                name: "EditUserComponent",
                component: EditUserComponent,
                props: true,
            },
            {
                path: "/dashboard/create",
                name: "CreateComponent",
                component: CreateComponent,
            },
            {
                path: "/dashboard/role",
                name: "RoleComponent",
                component: RoleComponent,
            },
            {
                path: "/dashboard//task",
                name: "DoneTaskComponent",
                component: DoneTaskComponent,
            },
            {
                path: "/dashboard/profile",
                name: "ProfileComponent",
                component: ProfileComponent,
            },
            {
                path: "/dashboard/createTask",
                name: "CreateTaskComponent",
                component: CreateTaskComponent,
            },
            {
                path:"/dashboard/test",
                name:"TestComponent",
                component:TestComponent,
            }
        ],
    },
    // {
    //     path: "/user",
    //     name: "UserPage",
    //     component: UserPage,
    //     beforeEnter: (to, from, next) => {
    //         const token = localStorage.getItem("token");
    //         const role_id = localStorage.getItem("role_id");
    //         if (token) {
    //             next();
    //         } else {
    //             next("/");
    //         }
    //     },
    // },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");
    const role_id = localStorage.getItem("role_id");

    const authPageRoutes = ["LoginPage", "RegisterPage"];

    if (token) {
        if (authPageRoutes.includes(to.name)) {
            if (role_id === "1" || role_id === "2") {
                next("/dashboard");
            } else if (role_id === "3") {
                next("/user");
            } else {
                next("/");
            }
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
