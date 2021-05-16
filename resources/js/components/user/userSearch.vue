<template>
    <v-dialog @update:return-value="reset()" v-model="dialog" max-width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                icon
                small
                class="mr-1"
                v-bind="attrs"
                v-on="on"
                @click="getUsers()"
            >
                <v-icon>mdi-account-plus</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-progress-linear
                :active="!loaded"
                :indeterminate="!loaded"
                color="primary"
            ></v-progress-linear>
            <!-- Menu Contents :disabled="loaded" -->
            <v-card-actions class="pa-1">
                <v-spacer></v-spacer>
                <v-btn @click="dialog = false" icon small>
                    <v-icon>
                        mdi-close
                    </v-icon>
                </v-btn>
            </v-card-actions>
            <v-card-text>
                <v-autocomplete
                    v-model="user"
                    :items="userList"
                    filled
                    chips
                    color="blue-grey lighten-2"
                    label=""
                    item-text="name"
                    item-value="id"
                >
                    <template v-slot:selection="data">
                        <v-chip
                            v-bind="data.attrs"
                            :input-value="data.selected"
                            @click="data.select"
                        >
                            <v-avatar left>
                                <v-img
                                    :src="data.item.userdata.profile_pic"
                                ></v-img>
                            </v-avatar>
                            {{ data.item.name }}
                        </v-chip>
                    </template>

                    <template v-slot:item="data">
                        <v-list-item-avatar color="primary">
                            <img
                                v-if="data.item.userdata.profile_pic"
                                :src="data.item.userdata.profile_pic"
                            />
                            <span
                                v-if="!data.item.userdata.profile_pic"
                                class="white--text mx-auto"
                            >
                                {{ data.item.name.charAt(0).toUpperCase() }}
                            </span>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title
                                v-html="data.item.name"
                            ></v-list-item-title>
                            <v-list-item-subtitle
                                v-html="data.item.userdata.job_title"
                            ></v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-autocomplete>
            </v-card-text>
            <v-card-actions>
                <v-btn @click="switchToInvite()" class="main-gradient" dark>
                    Invite
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn @click="addUser()" class="main-gradient" dark>
                    Add
                </v-btn>
            </v-card-actions>
            <!-- Menu Contents -->
        </v-card>
    </v-dialog>
</template>

<script>
const srcs = {
    1: "https://cdn.vuetifyjs.com/images/lists/1.jpg",
    2: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
    3: "https://cdn.vuetifyjs.com/images/lists/3.jpg",
    4: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
    5: "https://cdn.vuetifyjs.com/images/lists/5.jpg"
};

export default {
    components: {},
    data: () => ({
        dialog: false,
        loaded: true,
        user: null,
        userList: [
            { name: "Sandra Adams", group: "Group 1", avatar: srcs[1] },
            { name: "Ali Connors", group: "Group 1", avatar: srcs[2] },
            { name: "Trevor Hansen", group: "Group 1", avatar: srcs[3] },
            { name: "Tucker Smith", group: "Group 1", avatar: srcs[2] },
            { name: "Britta Holt", group: "Group 2", avatar: srcs[4] },
            { name: "Jane Smith ", group: "Group 2", avatar: srcs[5] },
            { name: "John Smith", group: "Group 2", avatar: srcs[1] },
            { name: "Sandra Williams", group: "Group 2", avatar: srcs[3] }
        ]
    }),
    methods: {
        switchToInvite() {
            this.$emit("user:invite");
            this.dialog = false;
        },
        reset() {
            setTimeout(() => {
                this.user = null;
            }, 200);
        },
        getUsers() {
            axios
                .get("membership/notusers/" + localStorage.getItem("company"))
                .then(response => {
                    this.userList = response.data;
                })
                .catch(response => {
                    console.log(response);
                });
        },
        addUser() {
            this.loaded = false;
            axios
                .post("membership/store", {
                    id: this.user,
                    company: localStorage.getItem("company")
                })
                .then(response => {
                    if (response.status == 201) {
                        this.$emit("new:membership");
                        this.loaded = true;
                        setTimeout(() => {
                            this.dialog = false;
                        }, 500);
                    }
                })
                .catch(response => {
                    console.log(response.status);
                    console.log(response.data);
                });
        }
    },
    created() {
        this.$on("update:return-value", this.reset);
        this.getUsers();
    },
    mounted() {}
};
</script>

<style></style>
