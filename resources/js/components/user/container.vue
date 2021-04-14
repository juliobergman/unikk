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
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        @click="showUser(user)"
                    >
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
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
    methods: {
        getAllUsers() {
            // Get Users
            axios
                .get("user/all")
                .then(response => {
                    this.users = response.data;
                })
                .catch(res => {
                    let errors = JSON.parse(res.request.response);
                    console.log(errors);
                });
        },
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
        }
    },
    created() {
        this.getAllUsers();
    },
    mounted() {}
};
</script>

<style scoped>
td {
    cursor: pointer;
}
</style>
