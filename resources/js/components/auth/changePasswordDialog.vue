<template>
    <v-dialog
        v-model="dialog"
        max-width="375"
        @update:return-value="initialState()"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" icon small class="mr-4">
                <v-icon>mdi-account-lock</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-toolbar flat>
                    <v-toolbar-title>
                        Change Password
                    </v-toolbar-title>
                </v-toolbar>

                <v-card-text class="pt-5">
                    <v-text-field
                        v-model="user.old_password"
                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required, rules.min]"
                        :type="show1 ? 'text' : 'password'"
                        label="Old Password"
                        name="old_password"
                        hint="At least 8 characters"
                        counter
                        @click:append="show1 = !show1"
                    ></v-text-field>

                    <v-divider></v-divider>

                    <v-text-field
                        v-model="user.password"
                        :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.min, rules.required]"
                        :type="show2 ? 'text' : 'password'"
                        label="New Password"
                        counter
                        @click:append="show2 = !show2"
                    ></v-text-field>

                    <v-text-field
                        v-model="user.password_confirmation"
                        :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.min, passwordConfirmationRule]"
                        :type="show3 ? 'text' : 'password'"
                        label="Confirm New Password"
                        counter
                        @click:append="show3 = !show3"
                    ></v-text-field>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text block @click="submit()">
                        Change Password
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
        <alert ref="alert"></alert>
    </v-dialog>
</template>
<script>
import alert from "../ui/alert.vue";
export default {
    props: ["bus"],
    components: {
        alert
    },
    data: () => ({
        valid: true,
        show1: false,
        show2: false,
        show3: false,
        dialog: false,
        loaded: false,
        password: "",
        user: {
            old_password: "",
            password: "",
            password_confirmation: ""
        },
        rules: {
            required: value => !!value || "Required.",
            min: v => v.length >= 8 || "Min 8 characters"
        }
    }),
    computed: {
        passwordConfirmationRule() {
            return () =>
                this.user.password === this.user.password_confirmation ||
                "Password must match";
        }
    },
    methods: {
        initialState() {
            this.dialog = false;
            this.user = {
                old_password: "",
                password: "",
                password_confirmation: ""
            };
        },
        submit() {
            axios
                .put("user/newpassword", this.user)
                .then(response => {
                    if (response.status == 200) {
                        this.$refs.alert
                            .open(
                                "Password Changed",
                                "Your password has been succesfully changed...",
                                {
                                    color: "success"
                                }
                            )
                            .then(() => {
                                this.initialState();
                            });
                    }
                })
                .catch(response => {
                    if (response.response.status == 403) {
                        this.$refs.alert
                            .open("Warning", response.response.data.message, {
                                color: "warning"
                            })
                            .then(() => {
                                // this.initialState();
                            });
                    }
                    console.error(response.response.data.message);
                    console.error(response.response.data.message);
                    console.error(response.response.data.errors);
                });
        }
    }
};
</script>
