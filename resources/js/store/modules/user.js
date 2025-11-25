import requester from "../../modules/requester";

export default {
    namespaced: true,

    state: {
        user: null,
        isLoading: false,
        isAuthenticated: localStorage.getItem('isAuthenticated') === 'true',
    },

    getters: {
        isAuthenticated: (state) => state.isAuthenticated
    },

    mutations: {
        setAuthenticated(state, isAuthenticated) {
            state.isAuthenticated = isAuthenticated
        },
    },

    actions: {
        login({ commit }, credentials) {
            return requester.sendGet('/sanctum/csrf-cookie')
                .then(response => {return requester.sendPost('/login', credentials)})
                .then(response => {
                    localStorage.setItem('isAuthenticated', 'true');
                    commit('setAuthenticated', true);
                    return response;
                })
            ;
        },

        registration({ commit }, credentials) {
            return requester.sendGet('/sanctum/csrf-cookie')
                .then(response => {return requester.sendPost('/register', credentials)})
                .then(data => {
                    localStorage.setItem('isAuthenticated', 'true');
                    commit('setAuthenticated', true);
                    return data;
                })
            ;
        },

        logout({ commit }) {
            return requester.sendPost('logout')
                .then(data => {
                    localStorage.setItem('isAuthenticated', 'false');
                    commit('setAuthenticated', false);
                    return data;
                })
        },

        forgotPassword({ commit }, data) {
            return requester.sendPost('/forgot-password', data);
        },

        resetPassword({ commit }, data) {
            return requester.sendPost('/reset-password', data);
        }
    }
}
