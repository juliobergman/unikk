<template>
    <v-app-bar id="vAppBar" flat color="rgba(0,0,0,0)" fixed>
        <v-container fluid class="pa-0 ma-0 fill-height d-flex align-center">
            <v-btn tile icon class="pa-2 my-auto" disabled>
                <nav-logo :fill="darkLogo"></nav-logo>
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn
                @click="busEmit('drawer:toggle')"
                :dark="darkBtn"
                class="mr-2"
                icon
                small
            >
                <v-icon> mdi-dots-vertical </v-icon>
            </v-btn>
        </v-container>
    </v-app-bar>
</template>

<script>
import { bus } from "../../../../bus";
import navLogo from "./icons/main.vue";
export default {
    components: {
        navLogo
    },
    data: () => ({
        activeSection: "welcome"
    }),
    computed: {
        darkBtn() {
            return this.$route.meta.darkBtn;
        },
        darkLogo() {
            return this.$route.meta.darkLogo ? "#FFFFFF" : "#272727";
        }
    },
    methods: {
        busEmit(name, data = null) {
            bus.$emit(name, data);
        }
    },
    mounted() {}
};
</script>

<style></style>
