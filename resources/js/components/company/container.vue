<template>
    <v-main>
        <company-profile :bus="bus"></company-profile>
        <v-divider v-show="!darkTheme"></v-divider>
        <v-spacer v-show="darkTheme" class="my-6"></v-spacer>
        <work-group :bus="bus"></work-group>
    </v-main>
</template>

<script>
import CompanyProfile from "./profile";
import WorkGroup from "./workgroup";
export default {
    props: ["bus"],
    components: {
        CompanyProfile,
        WorkGroup
    },
    computed: {
        darkTheme() {
            return this.$vuetify.theme.dark ? true : false;
        }
    }
};
</script>

<style></style>
