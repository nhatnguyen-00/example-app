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
        loading: false,
    },
    getters: {},
    actions: {
        register: ({ commit }, user) => {},
        login: ({ commit }, user) => {
            commit('showLoading');
            return axiosClient
                .post('/login', user)
                .then(({ data }) => {
                    commit('setUser', data);
                    commit('hideLoading');
                    return data;
                })
                .catch((e) => {
                    commit('hideLoading');
                    errorMess.value = e.response.data.msg;
                });
        },

        logout: ({ commit }, user) => {
            commit('showLoading');
            return axiosClient
                .post('/logout', user)
                .then(({ data }) => {
                    commit('logout', data);
                    commit('hideLoading');
                    return data;
                })
                .catch((e) => {
                    commit('hideLoading');
                    errorMess.value = e.response.data.msg;
                });
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
