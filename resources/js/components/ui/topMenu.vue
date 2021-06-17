<template>
    <div class="text-center">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn icon small v-bind="attrs" v-on="on">
                    <v-icon>
                        mdi-cog
                    </v-icon>
                </v-btn>
            </template>
            <v-list dense>
                <v-list-item>
                    <v-list-item-action>
                        <v-switch
                            v-model="$vuetify.theme.dark"
                            @click="darkMode()"
                            color="orange"
                        ></v-switch>
                    </v-list-item-action>
                    <v-list-item-title>Dark Mode</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item
                    v-for="(link, idx) in links"
                    :key="idx"
                    :to="link.to ? link.to : ''"
                    @click="link.emit ? bus.$emit(link.emit) : ''"
                    link
                >
                    <v-list-item-icon>
                        <v-icon v-text="link.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title
                            v-text="link.text"
                        ></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="logout()" link>
                    <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title> Logout </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        links: [
            {
                text: "My Account",
                icon: "mdi-account",
                to: "account"
            },
            {
                text: "New Company",
                icon: "mdi-domain-plus",
                emit: "newCompany"
            }
        ]
    }),
    methods: {
        darkMode() {
            // this.bus.$emit("updateChart");
            // this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            localStorage.setItem(
                "dark_theme",
                this.$vuetify.theme.dark.toString()
            );
        },
        logout() {
            axios
                .post("/logout")
                .then(response => {
                    if (response.status == 204) {
                        window.location.replace("/login");
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        // Dark Theme
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
