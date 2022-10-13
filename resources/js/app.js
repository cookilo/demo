import "bootstrap/dist/css/bootstrap.min.css"
import { createApp } from 'vue'
import App from './vue/App.vue'
import router from './vue/router'
import store from './vue/store'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp(App)
app.component('Datepicker', Datepicker)
app.use(router);
app.use(store);

app.mount('#app')
