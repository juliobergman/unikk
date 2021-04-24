<template>
    <v-app id="inspire">
        <v-main class="align-center">
            <v-lazy
                v-model="isActive"
                :options="{
                    threshold: 1
                }"
                transition="fade-transition"
            >
                <v-card class="mx-auto" max-width="400" flat>
                    <v-img
                        fill="blue"
                        class="mx-auto"
                        width="100"
                        contain
                        src="/ui/icon-outline.svg"
                    ></v-img>
                    <v-card-title v-if="false">Login</v-card-title>
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
