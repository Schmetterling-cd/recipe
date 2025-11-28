import axios from "axios";
import router from "./router";
import { toast } from "vue3-toastify";
import loader from './loader';
import appStore from '../store/appStore';

export default {
    isRedirect(data) {
        return data.hasOwnProperty('action') && data.action === 'redirect';
    },

    isHasMessage(data) {
        return data.hasOwnProperty('message');
    },

    isUnauthenticated(error) {
        return error.hasOwnProperty('status') && error.status === 401;
    },

     responseHandler(response) {
        const data = response.data ?? {};

        if (this.isHasMessage(data)) {
            this.showMessage(data.message);
        }

        if (this.isRedirect(data)) {
            router.push(data.to);
        }

        return data;
    },

    errorHandler(error) {
        if (this.isHasMessage(error)) {
            this.showMessage(error.message, 'error');
        }

        if (this.isUnauthenticated(error)) {
            appStore.commit('user/setAuthenticated', false);
            router.push({ name: 'Login' });
        }
    },

    showMessage(message, type = 'info') {
        toast[type](message);
    },

    sendPost(url, data, config = {}) {
        loader.showLoader(url);

        return axios.post(url, data, config)
            .then(response => {
                return this.responseHandler(response);
            })
            .catch(error => {
                this.errorHandler(error);
                return error;
            })
            .finally(() => {
                loader.hideLoader(url);
            })
        ;
    },

    sendDelete(url, config = {}) {
        loader.showLoader(url);

        return axios.delete(url, config)
            .then(response => {
                return this.responseHandler(response);
            })
            .catch(error => {
                this.errorHandler(error);
                return error;
            })
            .finally(() => {
                loader.hideLoader(url);
            })
        ;
    },

    async sendGet(url, config) {
        loader.showLoader(url);

        return await axios.get(url, config)
            .then(response => {
                return this.responseHandler(response);
            })
            .catch(error => {
                this.errorHandler(error);
                return error;
            })
            .finally(() => {
                loader.hideLoader(url);
            })
        ;
    },
}


