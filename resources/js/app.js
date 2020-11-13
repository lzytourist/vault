require('./bootstrap');

import Vue from "vue";
import router from "./plugins/router";
import vuetify from "./plugins/vuetify";
import store from "./plugins/store";

import App from "./components/App";

const app = new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    components: {
        App
    }
})
