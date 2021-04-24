<template>
    <v-main>
        <!-- Tools -->
        <v-toolbar class="border-bottom" dense>
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn @click="reguser = !reguser" icon small class="mr-1">
                <v-icon>mdi-account-plus</v-icon>
            </v-btn>
        </v-toolbar>
        <!-- Register User Dialog -->
        <v-dialog
            v-model="reguser"
            width="400"
            @click:outside="closeUserDialog()"
        >
            <user-form
                :bus="bus"
                ref="userform"
                v-bind:update-user="updateUser"
                v-on:success="userRegistered()"
            ></user-form>
        </v-dialog>

        <!-- Table -->
        <v-simple-table fixed-header>
            <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left">
                            Name
                        </th>
                        <th class="text-left">
                            Email
                        </th>
                        <th class="text-left">
                            Role
                        </th>
                        <th class="text-center">
                            Verified
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        @click="showUser(user)"
                    >
                        <td nowrap>{{ user.name }}</td>
                        <td nowrap>{{ user.email }}</td>
                        <td nowrap>{{ user.role }}</td>
                        <td
                            nowrap
                            class="text-center"
                            v-if="user.email_verified_at"
                        >
                            <v-icon color="accent">
                                mdi-account-check
                            </v-icon>
                        </td>
                        <td class="text-center" v-if="!user.email_verified_at">
                            <v-icon color="disabled">
                                mdi-account-remove
                            </v-icon>
                        </td>
                    </tr>
                </tbody>
            </template>
        </v-simple-table>
    </v-main>
</template>

<script>
import UserForm from "./userForm";
export default {
    components: {
        UserForm
    },
    props: ["bus"],
    data: () => ({
        updateUser: {},
        reguser: false,
        users: []
    }),
    computed: {
        company() {
            return this.$store.state.membership.company;
        }
    },
    methods: {
        closeUserDialog() {
            this.reguser = false;
            setTimeout(() => (this.updateUser = {}), 100);
            this.bus.$emit("closeUserDialog");
        },
        showUser(user) {
            this.reguser = true;
            this.updateUser = user;
        },
        userRegistered() {
            this.closeUserDialog();
            this.getAllUsers();
        },
        getUsers() {
            let cpy = this.company;
            if (!cpy) {
                cpy = localStorage.getItem("company");
            }
            axios
                .get("membership/users", {
                    headers: {
                        company: cpy
                    }
                })
                .then(response => {
                    console.log(response.data);
                    this.users = response.data;
                })
                .catch(response => {
                    let errors = JSON.parse(response.request.response);
                    console.log(errors);
                });
        }
    },
    created() {
        this.getUsers();
    },
    mounted() {
        this.bus.$on("companyChange", this.getUsers);
    }
};
</script>

<style scoped>
td {
    cursor: pointer;
}
</style>
