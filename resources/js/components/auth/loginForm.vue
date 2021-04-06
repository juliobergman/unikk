<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field
            v-model="user.email"
            :rules="rules.email"
            label="E-mail"
            required
        ></v-text-field>

        <v-text-field
            v-model="user.password"
            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="rules.password"
            :type="show ? 'text' : 'password'"
            name="password"
            label="Password"
            counter
            @click:append="show = !show"
        ></v-text-field>

        <v-checkbox v-model="user.remember" label="Remember Me"></v-checkbox>
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
            color="secondary"
            @click="login()"
        >
            Login

            <v-icon dark dense class="ml-2 align-self-end">
                mdi-login
            </v-icon>
        </v-btn>
    </v-form>
</template>

<script>
export default {
    data: () => ({
        user: {
            csrf_token: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            remember: "",
            email: "",
            password: ""
        },
        error: "",
        loading: false,
        valid: true,
        show: false,
        rules: {
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
        login() {
            this.loading = true;
            if (this.validate()) {
                this.$store
                    .dispatch("currentUser/loginUser", this.user)
                    .catch(error => {
                        this.error = error.response.data.msg;
                        setTimeout(() => (this.loading = false), 1000);
                    });
            } else {
                setTimeout(() => (this.loading = false), 1000);
            }
        }
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
