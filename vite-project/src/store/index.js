import { createStore } from 'vuex';
import axiosClient from '../axios.js';
import { hide, show } from 'uspin';

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
        loading: false,
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
        showLoading: ({ commit }, user) => {
            commit('showLoading');
        },
        hideLoading: ({ commit }, user) => {
            commit('hideLoading');
        },
    },
    mutations: {
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, userData) => {
            state.user.data = userData.user;
            state.user.token = userData.data.access_token;
            sessionStorage.setItem('TOKEN', state.user.token);
        },
        showLoading(state) {
            state.loading = true;
        },
        hideLoading(state) {
            state.loading = false;
        },
    },
    modules: {},
});

export default store;
