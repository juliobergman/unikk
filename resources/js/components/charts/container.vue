<template>
    <v-main>
        <v-toolbar elevation="2" dense>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn right>
                Button
            </v-btn>
            <v-btn left>
                Button
                <v-icon class="ml-2">mdi-album</v-icon>
            </v-btn>
        </v-toolbar>
        <v-container fluid v-if="loaded">
            <!-- No Records Found -->

            <v-alert
                v-model="norecords"
                border="left"
                close-text="Close"
                color="info"
                outlined
                dismissible
                transition="scroll-y-reverse-transition"
            >
                No Records has been found...
            </v-alert>

            <!-- Main Body -->
            <v-row>
                <v-col
                    cols="12"
                    sm="3"
                    v-for="(chart, idx) in chartdata"
                    :key="idx"
                >
                    <v-hover v-slot:default="{ hover }">
                        <v-card
                            class="py-3 pr-1"
                            :elevation="hover ? 6 : 3"
                            @click="showChart(chart.id)"
                            rounded="sm"
                            :loading="loading"
                        >
                            <chart-canvas
                                :mode="mode"
                                :chart="chart"
                            ></chart-canvas>

                            <v-card-title class="subtitle-1">
                                {{ chart.title }}
                            </v-card-title>
                        </v-card>
                    </v-hover>
                </v-col>
            </v-row>
            <!--  -->
            <v-dialog v-model="dialog" fullscreen eager hide-overlay>
                <v-card rounded="0">
                    <!-- Close -->
                    <v-btn class="float-right" small icon @click="closeChart()">
                        <v-icon small>mdi-close</v-icon>
                    </v-btn>
                    <!-- View -->
                    <router-view></router-view>
                </v-card>
            </v-dialog>
        </v-container>
    </v-main>
</template>

<script>
import chartCanvas from "./preview/chart";
import Chart from "./globalSettings";
export default {
    components: {
        chartCanvas
    },
    data: () => ({
        norecords: false,
        dialog: false,
        curretChart: "",
        loading: false,
        loaded: false,
        mode: "thumbnail",
        chartdata: null
    }),
    methods: {
        showChart(id) {
            this.curretChart = id;
            this.$router.push({ name: "viewChart", params: { id: id } });
            this.dialog = true;
        },
        closeChart() {
            this.curretChart = false;
            this.$router.push({ name: "charts" });
            this.dialog = false;
        }
    },
    async mounted() {
        this.loaded = false;
        try {
            let chartList = await axios.get("/api/v1/chart/all");
            this.chartdata = chartList.data;

            if (!chartList.data) {
                this.norecords = true;
            }

            this.loaded = true;
        } catch (e) {
            console.error(e);
        }
    },
    created() {
        if (this.$route.params.id) {
            this.dialog = true;
        }
    }
};
</script>
