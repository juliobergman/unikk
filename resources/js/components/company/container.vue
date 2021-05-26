<template>
    <v-main>
        <company-profile :bus="bus"></company-profile>
        <v-spacer class="my-5"></v-spacer>
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
    }
};
</script>

<style></style>
