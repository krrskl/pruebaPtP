import VueRouter from 'vue-router';

import Inicio from './components/Inicio';

const router = new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: [
    { path: '/', component: Inicio }
  ]
})

export default router;