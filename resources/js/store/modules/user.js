import requester from "../../modules/requester";

export default {
    namespaced: true,

    state: {
        isLoading: false,
        isAuthenticated: false,
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
        getUser() {
            return requester.sendGet('/api/user');
        },

        login({ commit }, credentials) {
            return requester.sendGet('/sanctum/csrf-cookie')
                .then(response => {return requester.sendPost('/login', credentials)})
                .then(response => {
                    commit('setAuthenticated', true);
                    return response;
                })
            ;
        },

        registration({ commit }, credentials) {
            return requester.sendGet('/sanctum/csrf-cookie')
                .then(response => {return requester.sendPost('/register', credentials)})
                .then(data => {
                    commit('setAuthenticated', true);
                    return data;
                })
            ;
        },

        logout({ commit }) {
            return requester.sendPost('/logout')
                .then(data => {
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
