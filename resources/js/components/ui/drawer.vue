<template>
    <v-navigation-drawer width="312" v-model="drawer" app>
        <!-- <template v-slot:append>
            <div>
                <v-divider class="my-0"></v-divider>
                <v-btn block text>
                    <v-icon small class="mr-2">
                        mdi-cog
                    </v-icon>
                    Options
                </v-btn>
            </div>
        </template> -->
        <template v-slot:prepend>
            <v-list-item two-line>
                <v-list-item-avatar
                    @click="bus.$emit('pickAvatar')"
                    color="primary"
                    size="56"
                >
                    <v-icon hover v-if="!user.profile_pic" large dark>
                        mdi-account-circle
                    </v-icon>
                    <img v-if="user.profile_pic" :src="user.profile_pic" />
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title> {{ user.name }} </v-list-item-title>
                    <v-list-item-subtitle v-if="membership">
                        {{ membership.job_title }}
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </template>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item-group v-model="selectedItem" color="secondary">
                <div v-for="item in items" :key="item.title">
                    <v-list-item
                        v-if="!item.children && checkAuth(item.auth)"
                        @click="
                            $router.push({ name: item.to }).catch(err => {})
                        "
                        link
                        color="primary"
                    >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>{{
                                item.title
                            }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <!-- List -->
                    <v-list-group
                        v-if="item.children"
                        no-action
                        :prepend-icon="item.icon"
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    item.title
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item
                            v-for="child in item.children"
                            :key="child.title"
                            @click="$router.push({ name: child.to })"
                            link
                        >
                            <!-- <v-list-item-icon>
                            <v-icon>{{ child.icon }}</v-icon>
                        </v-list-item-icon> -->
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    child.title
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                </div>
            </v-list-item-group>
        </v-list>

        <template v-slot:append v-if="!optionsBtn">
            <v-expansion-panels>
                <v-expansion-panel :key="1">
                    <v-expansion-panel-header>
                        Options
                        <template v-slot:actions>
                            <v-icon small>
                                mdi-cog
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <top-menu-content :bus="bus"></top-menu-content>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </template>
    </v-navigation-drawer>
</template>

<script>
import TopMenuContent from "./topMenuContent";
export default {
    props: ["bus", "optionsBtn"],
    components: { TopMenuContent },
    data: () => ({
        drawer: null,
        selectedItem: null,
        items: [
            {
                title: "Dashboard",
                icon: "mdi-view-dashboard",
                to: "dashboard",
                auth: ["admin", "editor", "user"]
            },
            {
                title: "Company",
                icon: "mdi-domain",
                to: "company",
                auth: ["admin", "editor", "user"]
            },
            {
                title: "Workgroup",
                icon: "mdi-account-group",
                to: "users",
                auth: ["admin"]
            },
            {
                title: "Charts",
                icon: "mdi-chart-areaspline",
                to: "charts",
                auth: ["admin", "editor", "user"]
            },
            {
                title: "Contacts",
                icon: "mdi-contacts",
                to: "contact",
                auth: ["admin", "editor", "user"]
            },
            {
                title: "Private Equity Funds",
                icon: "mdi-ferry",
                to: "pecc",
                auth: ["admin"]
            },
            {
                title: "Targets",
                icon: "mdi-target",
                to: "target",
                auth: ["admin"]
            },
            {
                title: "Financial",
                icon: "mdi-currency-usd",
                to: "financialStatement",
                auth: ["admin"]
            }
            // {
            //     title: "Charts",
            //     icon: "mdi-chart-areaspline",
            //     children: [
            //         {
            //             title: "My Charts",
            //             icon: "mdi-chart-areaspline-variant",
            //             to: "charts"
            //         },
            //         {
            //             title: "New Chart",
            //             icon: "mdi-chart-line",
            //             to: "newbarchart"
            //         }
            //     ]
            // }
        ]
    }),
    computed: {
        user() {
            return this.$store.state.user.user;
        },
        role() {
            return this.$store.state.membership.role;
        },
        membership() {
            return this.$store.state.membership.membership;
        }
    },
    methods: {
        toggleDrawer() {
            this.drawer = !this.drawer;
        },
        checkAuth(data) {
            return data.indexOf(this.role) < 0 ? false : true;
        }
    },
    mounted() {
        this.bus.$on("drawer", this.toggleDrawer);
        this.bus.$on("print:on", payload => {
            this.drawer = !payload;
        });
        // if (!this.$route.name) {
        //     this.$router.push({ name: "charts" });
        // }
    }
};
</script>
<style scoped>
.v-avatar img {
    object-fit: cover;
}
</style>
