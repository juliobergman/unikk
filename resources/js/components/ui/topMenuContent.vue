<template>
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
                <v-list-item-title v-text="link.text"></v-list-item-title>
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
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        links: [
            {
                text: "My Account",
                icon: "mdi-account",
                to: "app/account"
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
    mounted() {}
};
</script>

<style></style>
