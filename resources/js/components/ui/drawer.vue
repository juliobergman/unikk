<template>
    <v-navigation-drawer width="312" color="transparent" v-model="drawer" app>
        <template v-slot:prepend>
            <v-list-item two-line>
                <v-list-item-avatar color="primary" size="56">
                    <v-icon v-if="!user.profile_pic" large dark>
                        mdi-account-circle
                    </v-icon>
                    <img v-if="user.profile_pic" :src="user.profile_pic" />
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title> {{ user.name }} </v-list-item-title>
                    <v-list-item-subtitle v-if="user.job_title">
                        {{ user.job_title }}
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </template>

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
    props: ["bus", "user"],
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
    mounted() {
        this.bus.$on("drawer", this.toggleDrawer);
        // if (!this.$route.name) {
        //     this.$router.push({ name: "charts" });
        // }
    }
};
</script>
