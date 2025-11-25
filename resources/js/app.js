import './modules/bootstrap';

import {createApp} from 'vue'
import App from './components/App.vue'
import Router from "./modules/router";
import ToastPlugin from './modules/toast';
import AppStore from './store/appStore';

const app = createApp(App)
app.use(Router)
app.use(ToastPlugin)
app.use(AppStore)
app.mount('#app')

