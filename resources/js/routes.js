import PostCreate from './components/PostCreate';
import Posts from "./components/Posts";
import Register from "./components/Register";
import Login from "./components/Login";
import Dashboard from "./components/Dashboard";
import PostUpdate from './components/PostUpdate';
import PostDetail from "./components/PostDetail";
import Vue from 'vue';

import Router from 'vue-router';

Vue.use(Router)

export default new Router({


    routes: [

        {
            path: '/',
            component: Posts,
            name: "index"
        },
        {
            path: '/postcreate',
            component: PostCreate,
            name: "create",
            beforeEnter: (to, from, next) =>{
                axios.get('/api/authenticated').then(()=>{
                    next()
                }).catch(()=>{
                    return next({ name: 'Login'})
                })
            }
        },
        {
            path: '/registerapi',
            component: Register,
            name: 'Register'
        },
        {
            path: '/loginapi',
            component: Login,
            name: 'Login'
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
        },
        {
            path: "/postupdate/:slug",
            name: "postUpdate",
            component: PostUpdate,
            beforeEnter: (to, from, next) =>{
                axios.get('/api/authenticated').then(()=>{
                    next()
                }).catch(()=>{
                    return next({ name: 'Login'})
                })
            }

        },
        {
            path:"/post-detail/:slug",
            name: "post-detail",
            component: PostDetail
        },
        {
            path: "/dashboard/:id",
            name: "DashboardOfUser",
            component: Dashboard,
        },

    ]
});

