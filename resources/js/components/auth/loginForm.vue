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
            block
            outlined
            :loading="loading"
            :disabled="!valid || loading"
            color="primary"
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
                axios
                    .post("login", this.user)
                    .then(response => {
                        if (response.status === 204) {
                            window.location.replace("/app#/app");
                        }
                    })
                    .catch(res => {
                        let error = JSON.parse(res.request.response);
                        this.error = error.errors.email[0];
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
