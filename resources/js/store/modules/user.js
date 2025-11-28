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
            state.isAuthenticated = isAuthenticated;
        },
    },

    actions: {
        getUser({ commit }) {
            return requester.sendGet('/api/user')
                .then(data => {
                    if (data) {
                        commit('setAuthenticated', true);
                    }
                })
            ;
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
                .then(() => {
                    commit('setAuthenticated', false);
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
