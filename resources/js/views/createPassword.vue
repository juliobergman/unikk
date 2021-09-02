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
                <v-card class="mx-auto" max-width="400" flat outlined>
                    <v-toolbar flat>
                        <v-toolbar-title>Create your Password</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <create-password
                            :token="token"
                            :email="email"
                        ></create-password>
                    </v-card-text>
                </v-card>
            </v-lazy>
        </v-main>
    </v-app>
</template>

<script>
import createPassword from "../components/auth/createPasswordForm";
export default {
    props: ["token", "email"],
    components: { createPassword },
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
