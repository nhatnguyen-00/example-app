import store from './store';
import axios from 'axios';

const axiosClient = axios.create({
    baseURL: 'http://127.0.0.1/api/user/',
});

axiosClient.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;
    return config;
});

export default axiosClient;
