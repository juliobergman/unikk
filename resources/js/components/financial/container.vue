<template>
    <v-main>
        <report-container :bus="bus"></report-container>
    </v-main>
</template>

<script>
import reportContainer from "./section/reportContainer";
export default {
    props: ["bus"],
    components: {
        reportContainer
    }
};
</script>

<style></style>
