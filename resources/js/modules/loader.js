import { useLoading } from 'vue-loading-overlay';

const loading = useLoading();

export default {
    loader: {},

    showLoader(requestId) {
        this.loader[requestId] = loading.show({
            // опциональные параметры
            color: '#007bff',
            height: 64,
            width: 64,
            canCancel: false,
            backgroundColor: '#000000',
            opacity: 0.7
        });

        this.hideOtherLoaders(requestId);
    },

    hideOtherLoaders(requestId) {
        for (let key in this.loader) {
            if (key !== requestId) {
                this.hideLoader(key);
            }
        }
    },

    hideLoader(requestId) {
        if (this.loader.hasOwnProperty(requestId)) {
            this.loader[requestId].hide();
            delete this.loader[requestId];
        }
    },
}
