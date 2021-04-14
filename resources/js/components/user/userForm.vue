<template>
    <v-card>
        <v-card-title v-if="!currentUserId">Add New User</v-card-title>
        <v-card-title v-if="currentUserId">{{ updateUser.name }}</v-card-title>
        <v-card-text>
            <v-form ref="form" v-model="valid" lazy-validation>
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
                <!-- New User Btn -->
                <v-btn
                    v-if="!currentUserId"
                    class="btn-block mt-2"
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
                <!-- Update User Btn -->
                <v-btn
                    v-if="currentUserId"
                    class="btn-block mt-2"
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
                <alert ref="alert"></alert>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
import alert from "../ui/alert";
export default {
    components: {
        alert
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
            password: ""
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
            console.log(this.user);
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
        formDefaults() {
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
    created() {
        this.user.password = Math.random()
            .toString(36)
            .slice(-10);
    },
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
