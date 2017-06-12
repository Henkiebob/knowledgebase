
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//import vue router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from './routes';

const router = new VueRouter({
   routes
});

router.beforeEach((to, from, next) => {
  document.title = to.meta.title
  next()
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('VueHeader', require('./components/VueHeader.vue'));

Vue.component('Home', require('./pages/Home.vue'));

const app = new Vue({
    el: '#app',
    router
});
