<template>
    <v-app id="inspire">
        <v-progress-circular
            :size="80"
            color="primary"
            indeterminate
            class="progress-bar"
            v-if="progressBar"
        ></v-progress-circular>

        <Navigation v-if="getUser.email"/>
        <Login v-if="!getUser.email" />

        <v-main v-if="getUser.email">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </v-main>

        <v-snackbar
            v-model="snackbar.show"
            timeout="2000"
            fixed
            top
            right
        >
            {{ snackbar.text }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    color="blue"
                    text
                    v-bind="attrs"
                    @click="snackbar.show = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </v-app>
</template>

<script>
import Navigation from "./Navigation";
import {mapGetters, mapActions, mapMutations} from "vuex";
import Login from "./Login";

export default {
    name: "App",
    data () {
        return {
            loading: true,
        }
    },
    components: {
        Login,
        Navigation
    },
    computed: {
        ...mapGetters(["getUser", "snackbar", "progressBar"]),
    },
    methods: {
        ...mapActions(["userApi"]),
        ...mapMutations(["setSnackbar", "setProgressBar"]),
    },
    created() {
        if (localStorage.getItem('user_token')) {
            this.userApi()
        }
    }
}
</script>

<style>
* {
    outline: none;
}

.progress-bar {
    position: fixed;
    top: calc(50% - 40px);
    left: calc(50% - 40px);
    z-index: 93;
}
</style>
