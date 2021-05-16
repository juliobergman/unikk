<template>
    <v-dialog max-width="400" persistent v-model="noMembership">
        <v-card>
            <v-card-title>
                Sorry!
            </v-card-title>
            <v-card-text>
                Your Access has been revoked
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="logout()" color="primary">
                    ok
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data: () => ({
        noMembership: true
    }),
    methods: {
        logout() {
            axios.post("/logout").then(response => {
                window.location.href = "login";
            });
        }
    }
};
</script>

<style></style>
