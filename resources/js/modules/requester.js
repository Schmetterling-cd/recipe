import axios from "axios";
import router from "./router";

export default {
    isRedirect(data) {
        return data.hasOwnProperty('action') && data.action === 'redirect';
    },

    isHasMessage(data) {
        return data.hasOwnProperty('message');
    },

    async responseHandler(response) {
        const data = response.data ?? {};

        if (this.isRedirect(data)) {
            router.push(data.to);
            return;
        }

        if (this.isHasMessage(data)) {
            this.showMessage(data);
        }

        return data;
    },

    showMessage(message, type = 'success') {
        window.toast[type](message);
    },

    sendPost(url, data, config = {}) {
        return axios.post(url, data, config)
            .then(response => {
                return this.responseHandler(response);
            })
            .catch(error => {
                this.showMessage(error.message, 'error');
            })
        ;
    },

    sendDelete(url, config = {}) {
        return axios.delete(url, config)
            .then(response => {
                return this.responseHandler(response);
            })
            .catch(error => {
                this.showMessage(error.message, 'error');
            })
        ;
    },

    async sendGet(url, config) {
        return await axios.get(url, config)
            .then(response => {
                return this.responseHandler(response);
            })
            .catch(error => {
                this.showMessage(error.message, 'error');
            })
        ;
    },
}


