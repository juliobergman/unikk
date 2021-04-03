<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-avatar color="primary" size="36">
                <v-icon dark>
                    mdi-account-circle
                </v-icon>
            </v-avatar>
            <drawer-menu :user="currentUser"></drawer-menu>
        </v-navigation-drawer>
        <v-app-bar color="primary" dark app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>App</v-toolbar-title>
        </v-app-bar>
        <router-view></router-view>
    </v-app>
</template>

<script>
import drawerMenu from "../components/ui/drawer";
export default {
    props: ["title"],
    components: {
        drawerMenu
    },
    data: () => ({
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
        }
    },
    created() {
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("api_token");
        this.$store.dispatch("currentUser/getUser");
    }
};
</script>
