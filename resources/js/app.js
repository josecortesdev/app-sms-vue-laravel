import './bootstrap';
import { createApp } from 'vue';
import SmsSender from './components/SmsSender.vue'; 
import App from './App.vue'; 
import router from './router';
import 'bootstrap';


const app = createApp(App);
app.component('sms-sender', SmsSender);
app.use(router);
app.mount('#app');
