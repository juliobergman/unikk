<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field
            v-model="user.password"
            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.min, rules.required]"
            :type="show ? 'text' : 'password'"
            label="Password"
            counter
            @click:append="show = !show"
        ></v-text-field>

        <v-text-field
            v-model="user.password_confirmation"
            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.min, passwordConfirmationRule]"
            :type="show ? 'text' : 'password'"
            label="Confirm Password"
            counter
            @click:append="show = !show"
        ></v-text-field>

        <v-expand-transition>
            <v-alert v-show="this.error" dismissible dense type="error">
                {{ this.error }}
            </v-alert>
        </v-expand-transition>

        <v-btn
            class="btn-block"
            right
            :loading="loading"
            :disabled="!valid || loading"
            text
            @click="login()"
        >
            Login

            <v-icon dense class="ml-2 align-self-end">
                mdi-login
            </v-icon>
        </v-btn>
    </v-form>
</template>

<script>
export default {
    props: ["token", "email"],
    data: () => ({
        user: {
            email: "",
            temptoken: "",
            password: "",
            password_confirmation: ""
        },
        error: "",
        loading: false,
        valid: true,
        show: false,
        rules: {
            required: v => !!v || "Required.",
            min: v => v.length >= 1 || "Min 8 characters"
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
        login() {
            this.loading = true;
            if (this.validate()) {
                axios
                    .put("/user/create-new-password/", this.user)
                    .then(response => {
                        if (response.status === 200) {
                            window.location.replace("/app");
                        }
                    })
                    .catch(res => {
                        let error = JSON.parse(res.request.response);
                        this.error = error.errors.password[0];
                        setTimeout(() => (this.loading = false), 1000);
                    });
            } else {
                setTimeout(() => (this.loading = false), 1000);
            }
        }
    },
    computed: {
        passwordConfirmationRule() {
            return () =>
                this.user.password === this.user.password_confirmation ||
                "Password must match";
        }
    },
    created() {
        this.user.temptoken = this.token;
        this.user.email = this.email;
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
