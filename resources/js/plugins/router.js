import Vue from "vue";
import VueRouter from "vue-router";
import Dashboard from "../components/views/Dashboard";
import Help from "../components/views/Help";
import Expenditure from "../components/views/Expenditure";
import Credit from "../components/views/Credit";
import Note from "../components/views/Note";
import Login from "../components/Login";

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: Dashboard
    },
    {
        path: '/help',
        component: Help
    },
    {
        path: '/credit',
        component: Credit
    },
    {
        path: '/expenditure',
        component: Expenditure
    },
    {
        path: '/note',
        component: Note
    },
    {
        path: '/login',
        component: Login,
        name: 'Login'
    }
];

export default new VueRouter({
    routes,
    mode: 'history'
});
