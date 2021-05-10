<template>
    <v-app>
        <div class="main-background-color-gradient h-100">
            <drawer-menu :bus="bus" :user="user"></drawer-menu>
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
                <transition :name="transitionName" mode="out-in">
                    <router-view :key="$route.path" :bus="bus"></router-view>
                </transition>
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
        transitionName: "slide-right",
        bus: new Vue(),
        drawer: null,
        companies: []
    }),
    computed: {
        user: {
            get() {
                return this.$store.state.user.user;
            },
            set(val) {
                this.$store.commit("user/setUser", val);
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
        // Router Transitions
        this.$router.beforeEach((to, from, next) => {
            let toDepth = to.path.split("/").length;
            let fromDepth = from.path.split("/").length;
            this.transitionName =
                toDepth < fromDepth ? "slide-right" : "slide-left";

            if (to.meta.section != from.meta.section) {
                this.transitionName = "slide";
            }

            next();
        });
    },
    watch: {
        // $route(to, from) {
        //     let toDepth = to.path.split("/").length;
        //     let fromDepth = from.path.split("/").length;
        //     if (fromDepth == 2 && toDepth == fromDepth) {
        //         this.transitionName = "slide";
        //     } else {
        //         this.transitionName =
        //             toDepth < fromDepth ? "slide-right" : "slide-left";
        //     }
        // }
    }
};
</script>
<style scoped>
.slide-enter,
.slide-leave-to {
    opacity: 0;
    transform: translateY(-200vh);
}
.slide-left-leave-to,
.slide-right-enter {
    opacity: 0;
    transform: translateX(-100vw);
}
.slide-right-leave-to,
.slide-left-enter {
    opacity: 0;
    transform: translateX(100vw);
}

.slide-enter-active,
.slide-leave-active,
.slide-right-enter-active,
.slide-right-leave-active,
.slide-left-enter-active,
.slide-left-leave-active {
    transition: all 0.3s ease;
}
</style>
