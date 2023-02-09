import store from './store';
import axios from 'axios';

const axiosClient = axios.create({
    baseURL: 'http://localhost/api/user/',
});

axiosClient.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;
    return config;
});

export default axiosClient;
