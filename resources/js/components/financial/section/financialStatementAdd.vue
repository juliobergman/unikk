<template>
    <v-main id="section">
        <v-overlay color="white" opacity="1" :value="!loaded">
            <v-main>
                <v-progress-circular
                    color="primary"
                    indeterminate
                ></v-progress-circular>
            </v-main>
        </v-overlay>
        <fsa-toolbar :bus="bus"></fsa-toolbar>
        <v-divider></v-divider>
        <fsa-body @loaded="changeLoading" :bus="bus"></fsa-body>
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
    },
    data: () => ({
        loaded: true
    }),
    methods: {
        changeLoading($payload) {
            this.loaded = $payload;
        }
    }
};
</script>

<style>
.v-btn::before {
    background-color: transparent !important;
}
</style>
