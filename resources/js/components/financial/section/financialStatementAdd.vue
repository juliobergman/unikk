<template>
    <v-main id="section">
        <fsa-toolbar :bus="bus"></fsa-toolbar>
        <v-divider></v-divider>
        <fsa-body :bus="bus"></fsa-body>
    </v-main>
</template>

<script>
import FsaToolbar from "./components/fsaToolbar";
import FsaBody from "./components/fsaBody.vue";
export default {
    props: ["bus"],
    components: {
        FsaToolbar,
        FsaBody
    }
};
</script>

<style>
.v-btn::before {
    background-color: transparent !important;
}
</style>
