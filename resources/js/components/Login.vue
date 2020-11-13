<template>
    <v-app>
        <v-container>
            <v-row>
                <v-col sm="12" md="6" offset-md="3" class="my-auto">
                    <v-card class="blue-grey accent-2" dark elevation="0" shaped>
                        <v-card-title align="center">Login to Vault</v-card-title>
                        <v-card-text>
                            <v-form @keyup.enter="login">
                                <v-text-field
                                    label="Enter your email"
                                    prepend-icon="fa fa-envelope"
                                    v-model="user.email"
                                    :rules="emailRules"
                                    type="email"
                                ></v-text-field>
                                <v-text-field
                                    label="Enter your password"
                                    prepend-icon="fa fa-key"
                                    v-model="user.password"
                                    :rules="passwordRules"
                                    type="password"
                                ></v-text-field>
                                <v-btn @click="login" rounded class="blue accent-2 full-width" elevation="0">Login
                                </v-btn>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <div class="mx-auto">
                                <v-btn class="white--text" elevation="0" color="transparent">New here? Signup</v-btn>
                                <v-btn class="white--text" elevation="0" color="transparent">Forgot password?</v-btn>
                            </div>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "Login",
    data() {
        return {
            user: {
                email: null,
                password: null
            },
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            passwordRules: [
                v => !!v || 'Password is required'
            ]
        }
    },
    methods: {
        ...mapActions(["loginApi"]),
        login() {
            if (!this.user.email || !this.user.password) {
                return;
            }
            this.loginApi(this.user);
        }
    }
}
</script>

<style scoped>
.full-width {
    width: 100%;
}
</style>
