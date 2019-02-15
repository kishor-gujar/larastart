
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { Form, HasError, AlertError } from 'vform'
window.Form=Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import Vue from 'vue'
import VueRouter from 'vue-router'
import moment from 'moment'
import Dashobard from './components/Dashboard';
import ProfileComponent from './components/ProfileComponent';
import Users from './components/Users';
import Developer from './components/Developer';
Vue.use(VueRouter)
import VueProgressBar from 'vue-progressbar';
import swal from 'sweetalert';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

let routes =[

    {
        path:'/dashboard',
        name: 'dashboard',
        component: Dashobard
    },
    {
        path:'/profile', 
        name: 'profile',
        component: ProfileComponent
    },
    {
        path:'/users', 
        name: 'Users',
        component: Users
    },
    {
        path:'/developer', 
        name: 'Developer',
        component: Developer
    }
]

const router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
  })


  Vue.filter('upText' ,function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
  }); 


  Vue.filter('dateFormat', function(date){
     return moment(date).format('MMMM Do YYYY');
  });

  
  window.Fire =new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});


