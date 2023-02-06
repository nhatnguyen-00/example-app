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

        logout: ({ commit }, user) => {
            return axiosClient.post('/logout', user).then(({ data }) => {
                commit('logout', data);
                return data;
            });
        },
    },
    mutations: {
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            console.log(state);
            sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, userData) => {
            state.user.data = userData.user;
            state.user.token = userData.data.access_token;
            sessionStorage.setItem('TOKEN', state.user.token);
        },
    },
    modules: {},
});

export default store;
