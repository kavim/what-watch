/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import store from './store.js';

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('home', require('./components/Home.vue').default);
Vue.component('tvshow', require('./components/Tvshow.vue').default);

const app = new Vue({
    store,
    el: '#app',
});
