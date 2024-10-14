import api from "./axios";

const fetchUser = async () => {
    try {
        const res = await api.get("/users");
        const data = res.data.users;
        this.users = data;
    } catch (e) {
        console.log(e.message);
    }
};

export default fetchUser;
