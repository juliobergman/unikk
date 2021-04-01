<template>
    <div>
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right"
                >Email</label
            >

            <div class="col-md-6">
                <input
                    id="email"
                    type="email"
                    v-model="user.email"
                    class="form-control"
                    name="email"
                    required
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right"
                >Password</label
            >

            <div class="col-md-6">
                <input
                    id="password"
                    type="password"
                    v-model="user.password"
                    class="form-control"
                    name="password"
                    required
                />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        v-model="user.remember"
                    />

                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary" @click="login">
                    Login
                </button>

                <a class="btn btn-link" href="#">
                    Forgot Your Password?
                </a>
            </div>
        </div>
    </div>
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
        }
    }),
    methods: {
        login() {
            this.$store.dispatch("currentUser/loginUser", this.user);
        }
    }
};
</script>

<style></style>
