<template>
    <div>
        <router-view
            v-if="!chartDialog"
            :key="key"
            :bus="bus"
            :id="chartId"
        ></router-view>

        <v-dialog max-width="375" v-model="folderDialog">
            <new-folder :bus="bus"></new-folder>
        </v-dialog>

        <v-dialog v-model="chartDialog" fullscreen hide-overlay>
            <chart-container
                :bus="bus"
                :type="chartType"
                :id="chartId"
            ></chart-container>
        </v-dialog>
    </div>
</template>

<script>
import chartContainer from "./new/container";
import newFolder from "./new/folder";
export default {
    name: "chartMainComponent",
    components: {
        newFolder,
        chartContainer
    },
    props: ["bus"],
    data: () => ({
        key: 1,
        chartDialog: true,
        folderDialog: false,
        chartId: null,
        chartType: undefined
    }),
    methods: {
        forceRender() {
            this.key++;
        },
        showFDialog() {
            this.folderDialog = true;
        },
        showCDialog() {
            this.chartDialog = true;
        },
        closeDialog() {
            this.chartDialog = false;
        },
        closeFDialog() {
            this.folderDialog = false;
        },

        chartData($payload) {
            this.chartType = $payload.type;
        }
    },
    created() {
        if (this.$route.name == "chartView") {
            this.chartId = this.$route.params.id;
        }
    },
    mounted() {
        if (this.bus) {
            this.bus.$on("showDialog", this.showCDialog);
            this.bus.$on("showFDialog", this.showFDialog);
            this.bus.$on("closeDialog", this.closeDialog);
            this.bus.$on("closeFDialog", this.closeFDialog);
            this.bus.$on("chartData", this.chartData);
            this.bus.$on("saveChart", this.forceRender);
        }

        // if (this.$route.name == "charts") {
        //     this.$router.push({ name: "chartList" });
        // }
    }
};
</script>
