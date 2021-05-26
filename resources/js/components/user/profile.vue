<template>
    <div>
        <v-dialog @click:outside="reset()" v-model="dialog" width="375">
            <v-card>
                <v-progress-linear
                    v-if="!loaded"
                    indeterminate
                    class="main-gradient"
                ></v-progress-linear>
                <v-card tile flat dark>
                    <v-img
                        aspect-ratio="1/2"
                        src="/factory/stock/company-logo.jpg"
                    >
                        <v-card-actions
                            class="mb-0 pb-0 w-100"
                            style="position: absolute;"
                        >
                            <v-spacer></v-spacer>
                            <v-btn @click="reset()" icon x-small>
                                <v-icon>
                                    mdi-close
                                </v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-card-text
                            class="d-flex justify-center align-center flex-column"
                        >
                            <div>
                                <v-avatar size="120" class="align-self-center">
                                    <v-img :src="user.userdata.profile_pic">
                                    </v-img>
                                </v-avatar>
                            </div>
                            <v-list-item color="rgba(0, 0, 0, .4)">
                                <v-list-item-content>
                                    <v-list-item-title
                                        class="title text-center"
                                    >
                                        {{ user.name }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle
                                        class="text-wrap text-center"
                                    >
                                        {{ user.membership.job_title }}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-card-text>
                    </v-img>
                </v-card>

                <v-card-text class="pt-3">
                    <v-list two-line>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">
                                    mdi-email
                                </v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    E-mail
                                </v-list-item-subtitle>
                                <v-list-item-title>
                                    {{ user.email }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">
                                    mdi-cellphone
                                </v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    Phone
                                </v-list-item-subtitle>
                                <v-list-item-title>
                                    {{ user.userdata.phone }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">
                                    mdi-home
                                </v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    Address
                                </v-list-item-subtitle>
                                <v-list-item-title
                                    class="text-wrap"
                                    v-text="user.userdata.address"
                                >
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">
                                    mdi-timer-sand
                                </v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-subtitle>
                                    Member Since
                                </v-list-item-subtitle>
                                <v-list-item-title
                                    class="text-wrap"
                                    v-text="
                                        moment(user.created_at).format(
                                            'MMM, YYYY'
                                        )
                                    "
                                >
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-file-input
            v-show="false"
            id="avatar"
            name="avatar"
            ref="avatar"
            @change="submitAvatar"
        ></v-file-input>
    </div>
</template>

<script>
export default {
    props: ["bus", "id"],
    data: () => ({
        loaded: false,
        dialog: false,
        user: {
            userdata: {},
            membership: {}
        }
    }),
    methods: {
        reset() {
            (this.loaded = false), (this.dialog = false);
            this.user = { userdata: {}, membership: {} };
        },
        getUser(userId) {
            this.loaded = false;
            let data = {
                id: userId,
                company: localStorage.getItem("company")
            };

            if (userId) {
                axios
                    .post("user/show", data)
                    .then(response => {
                        this.user = response.data;
                        this.dialog = true;
                        this.loaded = true;
                    })
                    .catch(response => {});
            }
        },
        pickAvatar() {
            document.getElementById("avatar").click();
            // this.$refs.avatar.click();
        },
        submitAvatar(e) {
            let formData = new FormData();
            formData.append("avatar", e);

            axios
                .post("upload/avatar", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json"
                    }
                })
                .then(response => {
                    if (response.status == "200") {
                        this.$store.dispatch("user/getUser");
                    }
                })
                .catch(response => {
                    console.log(response.response.data.errors.avatar[0]);
                });
        }
    },
    created() {
        if (this.bus) {
            this.bus.$on("showUserProfile", this.getUser);
            this.bus.$on("pickAvatar", this.pickAvatar);
        }
        this.getUser();
    }
};
</script>

<style scoped></style>
