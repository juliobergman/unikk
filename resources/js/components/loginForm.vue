<template>
    <div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input
                type="email"
                class="form-control"
                id="email"
                v-model="user.email"
            />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                class="form-control"
                id="password"
                v-model="user.password"
            />
        </div>
        <button class="btn btn-primary" @click="login()">
            Submit
        </button>
    </div>
</template>

<script>
export default {
    data: () => ({
        user: {
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
