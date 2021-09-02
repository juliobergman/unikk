<template>
    <v-card>
        <v-form ref="form" v-model="valid" lazy-validation>
            <!-- <v-toolbar dark>
                <v-toolbar-title v-if="!currentUserId">
                    Add New User
                </v-toolbar-title>
                <v-toolbar-title class="text-center" v-if="currentUserId">
                    {{ updateUser.name }}
                </v-toolbar-title>
            </v-toolbar> -->

            <v-card v-if="!currentUserId" class="d-flex align-end" tile flat>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="title">
                            <v-icon small class="mr-2">
                                mdi-account-plus
                            </v-icon>

                            Add New User
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
            <v-card v-if="currentUserId" class="d-flex align-end" tile flat>
                <v-img
                    height="144px"
                    src="/factory/stock/company-background.jpg"
                >
                    <div
                        class="d-flex align-end pa-3 fill-height profile-bottom-gradient"
                    >
                        <v-avatar
                            v-if="updateUser.userdata.profile_pic"
                            size="120"
                        >
                            <v-img :src="updateUser.userdata.profile_pic">
                            </v-img>
                        </v-avatar>

                        <v-list-item color="rgba(0, 0, 0, .4)" dark>
                            <v-list-item-content>
                                <v-list-item-title class="title">
                                    {{ updateUser.name }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ updateUser.userdata.job_title }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </div>
                </v-img>
            </v-card>

            <v-card-text>
                <alert ref="alert"></alert>
                <confirm ref="confirm"></confirm>

                <v-text-field
                    v-model="user.name"
                    :rules="rules.required"
                    label="Name"
                    required
                    v-if="!currentUserId"
                ></v-text-field>

                <v-text-field
                    v-model="user.email"
                    :rules="rules.email"
                    label="E-mail"
                    required
                    :readonly="currentUserId"
                ></v-text-field>

                <v-text-field
                    v-model="user.job_title"
                    label="Job Title"
                ></v-text-field>

                <v-select
                    v-model="user.role"
                    :rules="rules.role"
                    :items="roles"
                    item-value="value"
                    label="Role"
                    required
                >
                </v-select>

                <v-expand-transition>
                    <v-alert v-show="this.error" dismissible dense type="error">
                        {{ this.error }}
                    </v-alert>
                </v-expand-transition>
            </v-card-text>
            <v-card-actions>
                <!-- New User Btn -->
                <v-btn
                    block
                    text
                    v-if="!currentUserId"
                    right
                    :loading="loading"
                    :disabled="!valid || loading"
                    @click="userRegister()"
                >
                    <v-icon dense class="mr-2">
                        mdi-account-plus
                    </v-icon>
                    Create
                </v-btn>
                <!-- Update/Delete User Btns -->

                <v-btn
                    text
                    color="danger"
                    v-if="currentUserId"
                    :loading="loading"
                    :disabled="!valid || loading"
                    @click="userDelete()"
                >
                    <v-icon dark dense class="mr-2">
                        mdi-account-cancel
                    </v-icon>
                    Revoke
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="currentUserId"
                    text
                    :loading="loading"
                    :disabled="!valid || loading"
                    @click="userUpdate()"
                >
                    <v-icon dark dense class="mr-2">
                        mdi-account-check
                    </v-icon>
                    Update
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
import alert from "../ui/alert";
import confirm from "../ui/confirm";
export default {
    components: {
        alert,
        confirm
    },
    props: {
        bus: {},
        updateUser: { type: Object, required: false, default: {} }
    },
    data: () => ({
        user: {},
        roleinf: false,
        roles: [
            { text: "Admin", value: "admin" },
            { text: "Editor", value: "editor" },
            { text: "User", value: "user" }
        ],
        error: "",
        loading: false,
        valid: true,
        show: false,
        rules: {
            required: [v => !!v || "This field is Required"],
            role: [v => !!v || "All users must have a role"],
            email: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            password: [v => !!v || "Password is Required"]
        }
    }),
    methods: {
        validate() {
            return this.$refs.form.validate();
        },
        loader() {
            this.loading = true;
            setTimeout(() => (this.loading = false), 3000);
        },
        userRegister() {
            this.loading = true;
            this.user.company = localStorage.getItem("company");
            this.user.password = Math.random()
                .toString(36)
                .slice(-8);
            this.user.temptoken = Math.random()
                .toString(36)
                .slice(-8);
            if (this.validate()) {
                console.log(this.user);
                axios
                    .post("/user/new", this.user)
                    .then(response => {
                        console.log(response);
                        if (response.status === 201) {
                            let msg =
                                "User " + this.user.name + " has been created.";

                            this.$refs.alert
                                .open("Success", msg, {
                                    color: "success"
                                })
                                .then(res => {
                                    setTimeout(
                                        () => (this.loading = false),
                                        100
                                    );

                                    this.$emit("user:success", res);
                                });
                        }
                    })
                    .catch(response => {
                        let errors = JSON.parse(response.request.response);
                        this.error = errors.errors.email[0];
                        setTimeout(() => (this.loading = false), 500);
                    });
            } else {
                setTimeout(() => (this.loading = false), 1000);
            }
        },
        userUpdate() {
            this.loading = true;

            axios
                .put("/membership", this.user)
                .then(response => {
                    setTimeout(() => (this.loading = false), 500);
                    if (response.status === 200) {
                        this.$emit("user:success");
                    }
                })
                .catch(response => {
                    let errors = JSON.parse(response.request.response);
                    this.error = errors.errors.email[0];
                    setTimeout(() => (this.loading = false), 500);
                });
        },
        userDelete() {
            this.loading = true;
            this.$refs.confirm
                .open("Revoke Membership", "Are you sure?", { color: "danger" })
                .then(response => {
                    if (response) {
                        axios
                            .delete("/membership/" + this.user.membership)
                            .then(response => {
                                setTimeout(() => (this.loading = false), 500);
                                let res = JSON.parse(response.request.response);
                                this.$refs.alert
                                    .open("Success", res["message"], {
                                        color: "success"
                                    })
                                    .then(res => {
                                        this.$emit("user:success");
                                    });
                            })
                            .catch(res => {
                                let error = JSON.parse(res.request.response);
                                this.$refs.alert.open("Error", error["error"], {
                                    color: "danger"
                                });
                            });
                    } else {
                        this.loading = false;
                    }
                });
        },
        formDefaults() {
            this.user = {};
            this.loading = false;
            this.$refs.form.reset();
            this.error = "";
        }
    },
    computed: {
        currentUserId() {
            this.user.id = this.updateUser.id;
            if (this.user.id) {
                this.user.name = this.updateUser.name;
                this.user.email = this.updateUser.email;
                this.user.job_title = this.updateUser.membership.job_title;
                this.user.membership = this.updateUser.membership.id;
                this.user.company = this.updateUser.membership.company_id;
                this.user.role = this.updateUser.membership.role;

                return true;
            }
            if (!this.user.id) {
                return false;
            }
        }
    },
    created() {
        this.user.id = this.userId;
    },
    mounted() {
        this.bus.$on("closeUserDialog", this.formDefaults);
        this.user.id = this.userId;
    },
    watch: {}
};
</script>

<style>
.custom-loader {
    animation: loader 1s infinite;
    display: flex;
}
@-moz-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-webkit-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-o-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
