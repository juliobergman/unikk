<template>
    <v-app>
        <div class="main-background-color-gradient h-100">
            <drawer-menu :bus="bus"></drawer-menu>
            <v-app-bar class="main-gradient" dark clipped-right app>
                <v-app-bar-nav-icon
                    @click="bus.$emit('drawer')"
                ></v-app-bar-nav-icon>

                <!--  -->
                <div
                    class="mx-auto ml-md-auto mr-md-0 flex-grow-1 flex-sm-grow-0 col-md-3"
                >
                    <v-select
                        class="col-12"
                        :menu-props="{ bottom: true, offsetY: true }"
                        hide-details
                        dense
                        outlined
                        :items="companies"
                        label=""
                        v-model="company"
                        @change="bus.$emit('companyChange')"
                    >
                    </v-select>
                </div>
                <div class="ml-2">
                    <v-tooltip v-if="!$vuetify.theme.dark" bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn
                                color="transparent"
                                elevation="1"
                                x-small
                                v-on="on"
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
                                color="transparent"
                                elevation="1"
                                x-small
                                v-on="on"
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
            <div class="p-3">
                <router-view :bus="bus"></router-view>
            </div>
        </div>
    </v-app>
</template>

<script>
import drawerMenu from "../components/ui/drawer";
import Confirm from "../components/ui/confirm";
export default {
    components: {
        drawerMenu,
        Confirm
    },
    data: () => ({
        bus: new Vue(),
        drawer: null,
        companies: []
    }),
    computed: {
        currentUser: {
            get() {
                return this.$store.state.user.user;
            }
        },
        company: {
            get() {
                return this.$store.state.membership.company;
            },
            set(val) {
                this.$store.commit("membership/setCompany", val);
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
            // this.bus.$emit("updateChart");
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            localStorage.setItem(
                "dark_theme",
                this.$vuetify.theme.dark.toString()
            );
        },
        companySelect() {
            axios.get("/membership/companies").then(response => {
                let comps = response.data;
                comps.forEach((e, index) => {
                    this.companies.push({
                        text: e.company.name,
                        value: e.id
                    });
                });
            });
        }
    },
    created() {
        this.$store.dispatch("user/getUser");
        this.$store.dispatch("membership/getCompany");
        this.companySelect();
    },
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
