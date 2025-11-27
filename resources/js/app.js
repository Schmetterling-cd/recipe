import './modules/bootstrap';

import {createApp} from 'vue'
import App from './components/App.vue'
import Router from "./modules/router";
import AppStore from './store/appStore';

const app = createApp(App)
app.use(Router)
app.use(AppStore)
app.mount('#app')

