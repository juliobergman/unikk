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
    })
};
</script>

<style></style>
