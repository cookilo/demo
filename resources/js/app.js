import { createApp } from 'vue'
import { createStore } from 'vuex'
import App from './vue/App.vue'
import router from './vue/router'
import store from './vue/store'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import vee from 'vee-validate';


const app = createApp(App)
app.component('Datepicker', Datepicker)
app.use(router);
// app.use(VeeValidate);
app.use(store);

app.mount('#app')
