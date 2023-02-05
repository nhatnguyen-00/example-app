import { createStore } from 'vuex';
import axiosClient from '../axios.js';

const store = createStore({
    state: {
        user: {
            data: {
                name: 'Hung Nguyen',
                email: 'hunghkm01@gmail.com',
                imageUrl: 'http://',
            },
            token: sessionStorage.getItem('TOKEN'),
        },
    },
    getters: {},
    actions: {
        register: ({ commit }, user) => {},
        login: ({ commit }, user) => {
            return axiosClient.post('/login', user).then(({ data }) => {
                commit('setUser', data);
                return data;
            });
        },
    },
    mutations: {
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
        },
        setUser: (state, userData) => {
            state.user.data = userData.user;
            state.user.token = userData.token;
            sessionStorage.setItem('TOKEN', state.user.token);
        },
    },
    modules: {},
});

export default store;
