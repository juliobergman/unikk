<template>
    <v-card>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-toolbar color="primary" dark>
                <v-toolbar-title v-if="!currentUserId">
                    Add New User
                </v-toolbar-title>
                <v-toolbar-title v-if="currentUserId">
                    {{ updateUser.name }}
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <alert ref="alert"></alert>
                <confirm ref="confirm"></confirm>
                <v-text-field
                    v-model="user.name"
                    :rules="rules.name"
                    label="Name"
                    required
                    :disabled="currentUserId"
                ></v-text-field>
                <v-text-field
                    v-model="user.email"
                    :rules="rules.email"
                    label="E-mail"
                    required
                    :disabled="currentUserId"
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
                    v-if="!currentUserId"
                    right
                    :loading="loading"
                    :disabled="!valid || loading"
                    color="primary"
                    @click="userRegister()"
                >
                    Create

                    <v-icon dark dense class="ml-2 align-self-end">
                        mdi-account-plus
                    </v-icon>
                </v-btn>
                <!-- Update/Delete User Btns -->

                <v-btn
                    v-if="currentUserId"
                    right
                    :loading="loading"
                    :disabled="!valid || loading"
                    color="danger"
                    dark
                    @click="userDelete()"
                >
                    Delete

                    <v-icon dark dense class="ml-2 align-self-end">
                        mdi-account-cancel
                    </v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="currentUserId"
                    right
                    :loading="loading"
                    :disabled="!valid || loading"
                    color="primary"
                    @click="userUpdate()"
                >
                    Update

                    <v-icon dark dense class="ml-2 align-self-end">
                        mdi-account-check
                    </v-icon>
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
        user: {
            id: null,
            name: "",
            email: "",
            role: "user",
            password: "",
            temptoken: ""
        },
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
            name: [v => !!v || "Name is Required"],
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
            this.user.password = Math.random()
                .toString(36)
                .slice(-8);
            this.user.temptoken = Math.random()
                .toString(36)
                .slice(-8);
            if (this.validate()) {
                axios
                    .post("user/new", this.user)
                    .then(response => {
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
                                        500
                                    );

                                    this.$emit("success", res);
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
                .put("user", this.user)
                .then(response => {
                    setTimeout(() => (this.loading = false), 500);
                    if (response.status === 200) {
                        this.$emit("success");
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
                .open("Delete User", "Are you sure?", { color: "danger" })
                .then(delc => {
                    if (delc) {
                        axios
                            .delete("user/" + this.user.id)
                            .then(response => {
                                setTimeout(() => (this.loading = false), 500);
                                let res = JSON.parse(response.request.response);
                                this.$refs.alert
                                    .open("Success", res["message"], {
                                        color: "success"
                                    })
                                    .then(res => {
                                        this.$emit("success");
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
            this.loading = false;
            this.$refs.form.reset();
            this.user.role = "user";
            this.error = "";
        }
    },
    computed: {
        currentUserId() {
            this.user.id = this.updateUser.id;
            if (this.user.id) {
                this.user.name = this.updateUser.name;
                this.user.email = this.updateUser.email;
                this.user.role = this.updateUser.role;

                return true;
            }
            if (!this.user.id) {
                return false;
            }
        }
    },
    created() {},
    mounted() {
        this.bus.$on("closeUserDialog", this.formDefaults);
        this.user.id = this.userId;
    }
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
