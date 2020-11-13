import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import user from "./modules/user";

export default new Vuex.Store({
    state: {
        snackbar: {
            show: false,
            text: ''
        },
        progressBar: false
    },
    mutations: {
        setSnackbar: (state, text) => {
            state.snackbar = {
                show: true,
                text: text
            };
        },
        setProgressBar: (state, progressBar) => {
            state.progressBar = progressBar;
        }
    },
    actions: {},
    getters: {
        snackbar: (state) => {
            return state.snackbar;
        },
        progressBar: (state) => {
            return state.progressBar;
        }
    },
    modules: {
        user
    }
});
