<template>
    <v-main>
        <v-toolbar class="mb-3" rounded elevation="2" dense>
            <v-btn icon @click="back(1)">
                <v-icon>
                    mdi-chevron-left
                </v-icon>
            </v-btn>
            <v-toolbar-title> Chart</v-toolbar-title>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
        </v-toolbar>
        <v-card>
            <h1>View</h1>
        </v-card>
    </v-main>
</template>

<script>
export default {
    data: () => ({
        loaded: false
    }),
    methods: {
        back(id) {
            this.loaded = false;
            setTimeout(() => {
                this.$router.push({
                    name: "chartCollection",
                    params: { id: id }
                });
            }, 100);
        }
    }
};
</script>

<style></style>
