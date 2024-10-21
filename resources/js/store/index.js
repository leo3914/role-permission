import { createStore } from "vuex";
import Users from "./modules/Users";
import Roles from "./modules/Roles";
import Tasks from "./modules/Tasks";


export default createStore({
    modules:{
        Users,
        Roles,
        Tasks
    }
});
