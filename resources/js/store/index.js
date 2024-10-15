import { createStore } from "vuex";
import Users from "./modules/users";
import Roles from "./modules/Roles";


export default createStore({
    modules:{
        Users,
        Roles
    }
});
