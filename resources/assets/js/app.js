
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));

// const app = new Vue({
//     el: '#app'
// });

import Vue from 'vue'
import VueRouter from 'vue-router'
// 1. Use plugin.
// This installs <router-view> and <router-link>,
// and injects $router and $route to all router-enabled child components
Vue.use(VueRouter)

// 2. Define route components
const Home = { template: '<div>home</div>' }
const Foo = { template: '<div>Foo</div>' }
const Bar = { template: '<div>Bar</div>' }
import User from './components/User.vue'
import Role from './components/Role.vue'
import Menu from './components/Menu.vue'
import Page from './components/Page.vue'
//


// 3. Create the router
const router = new VueRouter({
  hashbang: false,
  mode: 'hash', // or 'history'
  base: __dirname,
  routes: [
    { path: '/', component: Home },
    { path: '/foo', component: Foo },
    { path: '/bar', component: Bar },
    { path: '/menus', component: Menu },
    { path: '/pages', component: Page },
    { path: '/users', component: User }, // example of route with a seperate component
    { path: '/roles', component: Role } // example of route with a seperate component
  ]
})


// Vue.http.interceptors.push(function (request, next) {
//     //Add JWT to all requests
//     let token = localStorage.getItem('id_token');
//
//     if (token) {
//         request.headers.set('Authorization', 'Bearer ' + token);
//     }
//     next((response) => {
//         console.log(response.status);
//         if(response.status === 401) {
//             console.log('TOKEN EXPIRED.. Trying refresh..');
//             //store.commit('logout');
//
//         }
//     });
// }.bind(this));

new Vue({
  router,

  // components : {
  //   User
  // },

  data : {

  },

  methods:{

  }

}).$mount('#app')
