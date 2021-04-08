<template>
    <v-app id="inspire">
        <v-navigation-drawer expand-on-hover permanent v-model="drawer" app>
            <drawer-menu :user="currentUser"></drawer-menu>
        </v-navigation-drawer>
        <v-app-bar color="primary" dark app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>App</v-toolbar-title>
            <v-spacer></v-spacer>
            <!--  -->
            <div>
                <v-tooltip v-if="!$vuetify.theme.dark" bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn
                            elevation="1"
                            x-small
                            v-on="on"
                            color="primary"
                            fab
                            @click="darkMode"
                        >
                            <v-icon class="mr-1"
                                >mdi-moon-waxing-crescent</v-icon
                            >
                        </v-btn>
                    </template>
                    <span>Dark Mode On</span>
                </v-tooltip>

                <v-tooltip v-else bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn
                            elevation="1"
                            x-small
                            v-on="on"
                            color="primary"
                            fab
                            @click="darkMode"
                        >
                            <v-icon>mdi-white-balance-sunny</v-icon>
                        </v-btn>
                    </template>
                    <span>Dark Mode Off</span>
                </v-tooltip>
            </div>
            <!--  -->
        </v-app-bar>
        <router-view :bus="bus"></router-view>
    </v-app>
</template>

<script>
import drawerMenu from "../components/ui/drawer";
import Confirm from "../components/ui/confirm";
export default {
    props: ["title"],
    components: {
        drawerMenu,
        Confirm
    },
    data: () => ({
        bus: new Vue(),
        drawer: null
    }),
    computed: {
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
        },
        darkMode() {
            this.bus.$emit("updateChart");
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        }
    },
    created() {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("api_token");
        this.$store.dispatch("currentUser/getUser");
    }
};
</script>
