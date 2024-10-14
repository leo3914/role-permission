import axios from "axios";

const token = localStorage.getItem("token");
const api = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        // "X-Requested-With": "XMLHttpRequest",
        Authorization: token ? `Bearer ${token} ` : "",
    },
});

// api.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// api.interceptors.request.use(
//     config => {
//         // Attach the Authorization header dynamically
//         const token = localStorage.getItem('token');
//         if (token) {
//             config.headers['Authorization'] = `Bearer ${token}`;
//         }
//         return config;
//     },
//     error => {
//         return Promise.reject(error);
//     }
// );

export default api;
