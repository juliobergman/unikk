<template>
    <v-app id="inspire">
        <v-main class="mt-5">
            <v-lazy
                v-model="isActive"
                :options="{
                    threshold: 1
                }"
                transition="fade-transition"
            >
                <v-card class="mx-auto" max-width="400" elevation="3">
                    <v-toolbar color="primary" elevation="0" dark>
                        <v-toolbar-title>Login</v-toolbar-title>
                    </v-toolbar>

                    <v-card-text class="border-bottom mb-3">
                        <v-container fluid class="pa-0 ma-0">
                            <v-row dense>
                                <v-col cols="6"><strong>User:</strong></v-col>
                                <v-col cols="6">demo@mail.com</v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="6">
                                    <strong>Password:</strong>
                                </v-col>
                                <v-col cols="6">password</v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-text>
                        <login-form></login-form>
                    </v-card-text>
                </v-card>
            </v-lazy>
        </v-main>
    </v-app>
</template>

<script>
import loginForm from "../components/auth/loginForm";
export default {
    components: { loginForm },
    data: () => ({
        isActive: false
    }),
    mounted() {
        const theme = localStorage.getItem("dark_theme");
        if (theme) {
            if (theme === "true") {
                this.$vuetify.theme.dark = true;
            } else {
                this.$vuetify.theme.dark = false;
            }
        } else if (
            window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        ) {
            this.$vuetify.theme.dark = true;
            localStorage.setItem(
                "dark_theme",
                this.$vuetify.theme.dark.toString()
            );
        }
    }
};
</script>

<style></style>
