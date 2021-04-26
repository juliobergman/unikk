<template>
    <v-navigation-drawer color="transparent" v-model="drawer" app>
        <v-hover>
            <v-sheet
                color="transparent"
                class="py-1 px-2 d-flex align-items-center"
            >
                <v-avatar v-if="false" color="primary" size="36">
                    <v-icon dark>
                        mdi-account-circle
                    </v-icon>
                </v-avatar>
                <v-list-item-avatar>
                    <v-img src="storage/avatar-man-1.jpg"></v-img>
                </v-list-item-avatar>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title
                            @click="
                                $router
                                    .push({
                                        name: 'userprofile',
                                        params: { id: user.id }
                                    })
                                    .catch(err => {})
                            "
                            class="title"
                        >
                            {{ user.name }}
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ user.email }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <!-- <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn @click="logout()" icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-logout</v-icon>
                        </v-btn>
                    </template>
                    <span>Logout</span>
                </v-tooltip> -->
            </v-sheet>
        </v-hover>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item-group v-model="selectedItem" color="secondary">
                <div v-for="item in items" :key="item.title">
                    <v-list-item
                        v-if="!item.children"
                        @click="
                            $router.push({ name: item.to }).catch(err => {})
                        "
                        link
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
        <template v-slot:append>
            <div class="pa-2">
                <v-btn @click="logout()" class="main-gradient" dark block>
                    Logout
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        drawer: null,
        selectedItem: null,
        items: [
            { title: "Users", icon: "mdi-account", to: "users" },
            {
                title: "Charts",
                icon: "mdi-chart-areaspline",
                children: [
                    {
                        title: "My Charts",
                        icon: "mdi-chart-areaspline-variant",
                        to: "charts"
                    },
                    {
                        title: "New Chart",
                        icon: "mdi-chart-line",
                        to: "newchart"
                    }
                ]
            }
        ]
    }),
    methods: {
        toggleDrawer() {
            this.drawer = !this.drawer;
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
    computed: {
        user() {
            return this.$store.state.user.user;
        }
    },
    created() {
        this.user = this.$store.state.user.user;
    },
    mounted() {
        this.bus.$on("drawer", this.toggleDrawer);
        // if (!this.$route.name) {
        //     this.$router.push({ name: "charts" });
        // }
    }
};
</script>
