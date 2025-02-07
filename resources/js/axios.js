// axios
import axios from 'axios';
import router from "./router/index.js";

const axiosInstance = axios.create({
    baseURL: 'http://exercise.test/api/', // Replace with your Laravel API base URL
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
});

// Add a request interceptor to include the JWT token in headers
axiosInstance.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Optionally, handle responses globally
axiosInstance.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response.status === 401) {
            // authStore.logout()
            router.push({ name: 'login' });
        }
        return Promise.reject(error);
    }
);

export default axiosInstance;
