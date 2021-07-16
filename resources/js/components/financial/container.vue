<template>
    <v-main>
        <main-toolbar :bus="bus"></main-toolbar>
        <report-container :bus="bus"></report-container>
    </v-main>
</template>

<script>
import mainToolbar from "./ui/mainToolbar";
import reportContainer from "./section/reportContainer";
export default {
    props: ["bus"],
    components: {
        mainToolbar,
        reportContainer
    }
};
</script>

<style></style>
