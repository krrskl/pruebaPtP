import VueRouter from 'vue-router';

import Inicio from './components/Inicio';
import ResultTransaction from './components/ResultTransaction';

const router = new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: [
    { path: '/ptp/', component: Inicio },
    { path: '/ptp/statusTransaction', component: ResultTransaction }
  ]
})

export default router;