<template>
    <v-app>
        <div
            v-if="activeMembership"
            class="main-background-color-gradient h-100"
        >
            <drawer-menu
                :optionsBtn="topMenu"
                :bus="bus"
                :user="user"
            ></drawer-menu>
            <v-app-bar class="main-gradient" dark clipped-right app flat>
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
                        item-text="text"
                        item-value="value"
                        label=""
                        v-model="currentCompany"
                        v-if="showSelect"
                    >
                    </v-select>
                </div>
                <top-menu-btn v-if="topMenu" :bus="bus"></top-menu-btn>
                <!--  -->
            </v-app-bar>
            <div class="p-3">
                <transition :name="transitionName" mode="out-in">
                    <router-view :key="$route.path" :bus="bus"></router-view>
                </transition>
            </div>
        </div>
        <new-company-dialog
            @companyChange="companySelect()"
            :bus="bus"
        ></new-company-dialog>
        <no-membership-dialog v-if="!activeMembership"></no-membership-dialog>
        <profile-card :bus="bus"></profile-card>
    </v-app>
</template>

<script>
import drawerMenu from "../components/ui/drawer";
import Confirm from "../components/ui/confirm";
import profileCard from "../components/user/profileCard";
import newCompanyDialog from "../components/company/newCompanyDialog";
import topMenuBtn from "../components/ui/topMenu";

import NoMembershipDialog from "../components/ui/noMembershipDialog.vue";
export default {
    components: {
        drawerMenu,
        profileCard,
        newCompanyDialog,
        Confirm,
        NoMembershipDialog,
        topMenuBtn
    },
    data: () => ({
        isMobile: false,
        topMenu: true,
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
        currentCompany: {
            get() {
                return this.$store.state.membership.membership_id;
            },
            set(val) {
                this.$store.commit("membership/setMembershipId", val);
            }
        },
        activeMembership() {
            return this.$store.state.membership.active;
        },
        userRole() {
            return this.$store.state.membership.role;
        },
        membership() {
            return this.$store.state.membership.membership;
        },
        showSelect() {
            return this.companies.length > 1 ? true : false;
        }
    },
    methods: {
        onResize() {
            this.isMobile = window.innerWidth < 600;
            this.topMenu = window.innerWidth > 400;
        },
        logout() {
            axios.post("/logout").then(response => {
                window.location.href = "login";
            });
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
        this.$store.dispatch("membership/getMembership");
        this.$store.dispatch("membership/getMembershipId");
        this.$store.dispatch("membership/getCompanyId");
        this.companySelect();
    },
    beforeDestroy() {
        if (typeof window === "undefined") return;
        window.removeEventListener("resize", this.onResize, { passive: true });
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

        // Company Select
        this.bus.$on("companySelect", this.companySelect);
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
        this.onResize();
        window.addEventListener("resize", this.onResize, { passive: true });
    },
    watch: {
        currentCompany() {
            this.bus.$emit("companyChange");
        }
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
