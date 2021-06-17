<template>
    <v-main>
        <account-profile :bus="bus"></account-profile>
    </v-main>
</template>

<script>
import accountProfile from "./accountProfile";
export default {
    props: ["bus"],
    components: {
        accountProfile
    }
};
</script>

<style></style>
