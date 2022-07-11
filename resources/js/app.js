


require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('posts', require('./components/Posts.vue').default);
Vue.component('home', require('./components/Home').default);
Vue.component('post-create', require('./components/PostCreate.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);

Vue.component('login', require('./components/Login.vue').default);
Vue.component('register', require('./components/Register.vue').default);

Vue.component('comment', require('./components/Comment.vue').default);



import router from './routes';



const app = new Vue({
    router,
    el: '#app',
});
