<template>
    <div>
        <router-view key="coll" :bus="bus"></router-view>

        <v-dialog
            v-model="chartDialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <chart-container :bus="bus"></chart-container>
        </v-dialog>
    </div>
</template>

<script>
import chartContainer from "./new/container";
export default {
    components: {
        chartContainer
    },
    props: ["bus"],
    data: () => ({
        chartDialog: true
    }),
    methods: {
        newChart() {
            this.chartDialog = true;
        },
        closeDialog() {
            this.chartDialog = false;
        }
    },
    mounted() {
        this.bus.$on("newChart", this.newChart);
        this.bus.$on("closeDialog", this.closeDialog);
        // if (this.$route.name == "charts") {
        //     this.$router.push({ name: "chartList" });
        // }
    }
};
</script>
