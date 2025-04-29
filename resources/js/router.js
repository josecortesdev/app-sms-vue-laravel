import { createRouter, createWebHistory } from 'vue-router';
import SmsForm from './components/SmsForm.vue';
import SmsLogs from './components/SmsLogs.vue';
import SmsStats from './components/SmsStats.vue';
import Settings from './components/Settings.vue';
import SmsSender from './components/SmsSender.vue';

const routes = [
  {
      path: '/sms',
      component: SmsSender, // Usa SmsSender como contenedor principal
      children: [
          { path: '', component: SmsForm, name: 'send-sms' }, // Página principal
          { path: 'sms-logs', component: SmsLogs, name: 'sms-logs' },
          { path: 'sms-stats', component: SmsStats, name: 'sms-stats' },
          { path: 'settings', component: Settings, name: 'settings' },
      ],
  },
  // Redirige la raíz `/` a `/sms`
  { path: '/', redirect: '/sms' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;