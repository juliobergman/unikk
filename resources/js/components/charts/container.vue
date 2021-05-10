<template>
    <div>
        <router-view key="coll" :bus="bus"></router-view>

        <v-dialog v-model="chartDialog" fullscreen hide-overlay>
            <chart-container
                :update="updateChart"
                :id="chartId"
                :bus="bus"
            ></chart-container>
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
        chartDialog: false,
        chartId: null,
        updateChart: undefined
    }),
    methods: {
        showDialog() {
            this.chartDialog = true;
        },
        closeDialog() {
            this.chartDialog = false;
        },
        setUpdateChart(chartType) {
            this.updateChart = chartType;
        }
    },
    created() {
        if (this.$route.name == "chartView") {
            this.chartId = Number.parseInt(this.$route.params.id, 10);
        }
    },
    mounted() {
        this.bus.$on("showDialog", this.showDialog);
        this.bus.$on("closeDialog", this.closeDialog);
        this.bus.$on("setChartType", this.setUpdateChart);
        // if (this.$route.name == "charts") {
        //     this.$router.push({ name: "chartList" });
        // }
    }
};
</script>
