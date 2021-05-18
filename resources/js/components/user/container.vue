<template>
    <v-main>
        <!-- Loader -->
        <v-overlay v-if="false" :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>
        <!-- Tools -->
        <v-toolbar class="mb-3" elevation="2" flat rounded dense>
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <user-search
                @user:invite="userInfoDialog = true"
                @new:membership="getUsers()"
            ></user-search>
        </v-toolbar>
        <!-- Register User Dialog -->
        <v-dialog
            v-model="userInfoDialog"
            width="400"
            @click:outside="closeUserDialog()"
        >
            <user-form
                :bus="bus"
                ref="userform"
                v-bind:update-user="updateUser"
                @user:success="userRegistered()"
            ></user-form>
        </v-dialog>
        <!-- Table -->
        <v-data-table
            @click:row="showUser"
            :headers="headers"
            :items="users"
            item-key="name"
            :loading="!loaded"
            item-class="red"
            class="elevation-2"
            :footer-props="{
                showFirstLastPage: true,
                itemsPerPageOptions: [10]
            }"
        >
            <template v-slot:item.name="{ item, isMobile }">
                <v-list-item-avatar color="primary" v-if="!isMobile">
                    <img
                        :src="item.userdata.profile_pic"
                        v-if="item.userdata.profile_pic"
                        alt="Avatar"
                    />
                    <span
                        v-if="!item.userdata.profile_pic"
                        class="white--text overline mx-auto"
                    >
                        {{ item.name.charAt(0) }}
                    </span>
                </v-list-item-avatar>
                {{ item.name }}
                <v-avatar
                    color="primary"
                    v-if="isMobile"
                    size="35"
                    class="ml-2"
                >
                    <img
                        :src="item.userdata.profile_pic"
                        v-if="item.userdata.profile_pic"
                        alt="Avatar"
                    />
                    <span v-if="!item.userdata.profile_pic" class="white--text">
                        {{ item.name.charAt(0).toUpperCase() }}
                    </span>
                </v-avatar>
            </template>

            <template v-slot:item.role="{ item }">
                <v-chip
                    label
                    small
                    color="primary"
                    dark
                    class="d-block userchip"
                >
                    {{ item.membership.role }}
                </v-chip>
            </template>
            <template v-slot:item.email_verified_at="{ item }">
                <v-icon :color="getVerifiedColor(item.email_verified_at)">
                    {{ getVerifiedIcon(item.email_verified_at) }}
                </v-icon>
            </template>
        </v-data-table>
    </v-main>
</template>

<script>
import UserForm from "./userForm";
import UserSearch from "./userSearch";
export default {
    components: {
        UserForm,
        UserSearch
    },
    props: ["bus"],
    data: () => ({
        loaded: false,
        updateUser: {},
        userInfoDialog: false,
        headers: [
            {
                text: "Name",
                value: "name",
                align: "left"
            },
            { text: "Email", value: "email" },
            { text: "Role", value: "role", align: "center" },
            { text: "Verified", value: "email_verified_at", align: "center" }
        ],
        users: []
    }),
    methods: {
        getVerifiedColor(v) {
            if (v) return "accent";
            else return "disabled";
        },
        getVerifiedIcon(v) {
            if (v) return "mdi-account-check";
            else return "mdi-account-remove";
        },
        getUserRole(v) {},
        closeUserDialog() {
            this.userInfoDialog = false;
            setTimeout(() => (this.updateUser = {}), 100);
            this.bus.$emit("closeUserDialog");
        },
        showUser(user) {
            if (this.role == "admin") {
                this.userInfoDialog = true;
                this.updateUser = user;
            }
        },
        userRegistered() {
            this.closeUserDialog();
            this.getUsers();
        },
        getUsers() {
            this.loaded = false;
            if (this.company) {
                axios
                    .get("membership/users/" + this.company)
                    .then(response => {
                        this.users = response.data;
                        setTimeout(() => {
                            this.loaded = true;
                        }, 250);
                    })
                    .catch(response => {
                        let errors = JSON.parse(response.request.response);
                        console.log(errors);
                    });
            }
        }
    },
    computed: {
        company() {
            return this.$store.state.membership.company_id;
        },
        role() {
            return this.$store.state.membership.role;
        }
    },
    created() {
        this.getUsers();
    },
    mounted() {
        this.getUsers;
        this.bus.$on("companyChange", this.getUsers);

        // setTimeout(() => {
        //     this.showUser(this.users[1]);
        // }, 2000);
    },
    watch: {
        company() {
            this.getUsers();
        },
        role() {
            if (this.role != "admin") {
                this.$router.push({ path: "/" });
            }
        }
    }
};
</script>

<style scoped>
.pic {
    background: brown !important;
}

td {
    cursor: pointer;
}
.userchip {
    text-transform: capitalize;
}
</style>
