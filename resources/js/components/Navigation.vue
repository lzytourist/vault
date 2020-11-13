<template>
    <v-navigation-drawer v-model="drawer" dark app fixed class="deep-orange accent-2">
        <v-layout column align-center>
            <v-flex class="mt-5">
                <v-avatar size="100">
                    <img src="../assets/avatar.png" alt="">
                </v-avatar>
                <h4 class="white--text mt-1 text-center">{{ user.name }}</h4>
                <h6 class="white--text mt-1 text-center">{{ user.email }}</h6>
            </v-flex>
        </v-layout>
        <v-divider class="mt-5"></v-divider>
        <v-list shaped dense>
            <v-list-item to="/" exact>
                <v-list-item-action>
                    <v-icon>fas fa-window-restore</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item to="/credit" exact>
                <v-list-item-action>
                    <v-icon>fa fa-credit-card</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Credits / Balances</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item to="/expenditure" exact>
                <v-list-item-action>
                    <v-icon>fa fa-exclamation-triangle</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Expenditures</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item to="/note" exact>
                <v-list-item-action>
                    <v-icon>fa fa-sticky-note</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Notes</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item to="/help" exact>
                <v-list-item-action>
                    <v-icon>fa fa-question-circle</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Help</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <template v-slot:append>
            <div class="pa-2">
                <v-btn block elevation="0" @click="logoutApi">
                    Logout
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>
</template>

<script>
import {mapGetters, mapActions} from "vuex";

export default {
    name: "Navigation",
    data() {
        return {
            drawer: null,
            user: {}
        }
    },
    methods: {
        ...mapActions(["logoutApi"]),
        currentUser() {
            this.user = this.getUser
        }
    },
    computed: {
        ...mapGetters(["getUser"])
    },
    created() {
        this.currentUser()
    }
}
</script>

<style scoped>

</style>
