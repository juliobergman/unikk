<template>
    <v-btn @click="go()" tile text height="48">
        <v-icon>
            mdi-playlist-plus
        </v-icon>
    </v-btn>
</template>

<script>
export default {
    props: ["bus", "repport"],
    methods: {
        go() {
            this.$router.push({
                name: "financialStatementAdd"
            });
        }
    }
};
</script>

<style></style>
