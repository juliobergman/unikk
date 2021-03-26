<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">
                        Application
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        subtext
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense nav>
                <v-list-item v-for="item in items" :key="item.title" link>
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="logout()" link>
                    <v-list-item-icon>
                        <v-icon>mdi-power</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar color="indigo" dark app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>Application</v-toolbar-title>
        </v-app-bar>

        <v-main>
            Main content goes here
            <!--  -->
        </v-main>
    </v-app>
</template>

<script>
export default {
    data: () => ({
        items: [
            { title: "Dashboard", icon: "mdi-view-dashboard" },
            { title: "Photos", icon: "mdi-image" },
            { title: "About", icon: "mdi-help-box" }
        ],
        drawer: null
    }),
    computed: {
        loggedIn: {
            get() {
                return this.$store.state.currentUser.loggedIn;
            }
        },
        currentUser: {
            get() {
                return this.$store.state.currentUser.user;
            }
        }
    },
    methods: {
        logout() {
            axios.post("/logout").then(response => {
                window.location.href = "login";
            });
        }
    },
    created() {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("api_token");
        this.$store.dispatch("currentUser/getUser");
    }
};
</script>
