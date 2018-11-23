
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
// import VueMaterial from 'vue-material'
// import 'vue-material/dist/vue-material.min.css'
// import 'vue-material/dist/theme/black-green-dark.css'
// Vue.use(VueMaterial)

import Router from 'vue-router';
Vue.use(Router);

import router from './Router';

const app = new Vue({
    el: '#app',
    router
});