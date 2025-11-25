import Toast from 'vue-toast-notification'

// Импортируем стили
import 'vue-toast-notification/dist/theme-default.css'
// или для другого стиля:
// import 'vue-toast-notification/dist/theme-bootstrap.css'
// import 'vue-toast-notification/dist/theme-sugar.css'

export default {
    install: (app) => {
        // Настройки по умолчанию
        const toastOptions = {
            position: 'top-right',
            duration: 5000,
            dismissible: true,
            pauseOnHover: true
        };

        app.use(Toast, toastOptions);

        // Создаем глобальный экземпляр тоста
        const toast = {
            success: (message, options = {}) => {
                return app.config.globalProperties.$toast.success(message, options);
            },
            error: (message, options = {}) => {
                return app.config.globalProperties.$toast.error(message, options);
            },
            info: (message, options = {}) => {
                return app.config.globalProperties.$toast.info(message, options);
            },
            warning: (message, options = {}) => {
                return app.config.globalProperties.$toast.warning(message, options);
            },
            clear: () => {
                return app.config.globalProperties.$toast.clear();
            }
        };

        // Делаем тост доступным глобально
        app.config.globalProperties.$toast = toast;
        window.toast = toast;

        // Предоставляем через provide/inject
        app.provide('toast', toast);
    }
};
