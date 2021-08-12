<template>
    <v-main tag="div">
        <v-toolbar rounded flat dense>
            <v-btn icon @click="back()">
                <v-icon>
                    mdi-chevron-left
                </v-icon>
            </v-btn>
            <v-toolbar-title> {{ collection.title }} </v-toolbar-title>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn @click="bus.$emit('showDialog')" icon>
                <v-icon>
                    mdi-chart-box-plus-outline
                </v-icon>
            </v-btn>
        </v-toolbar>
        <v-divider></v-divider>
        <v-container v-if="loaded" fluid class="pa-0">
            <!-- No Records Found -->

            <v-alert
                v-model="norecords"
                border="left"
                close-text="Close"
                color="info"
                colored-border
                icon="mdi-select-search"
                dismissible
                transition="scroll-y-reverse-transition"
                elevation="2"
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
                            class="pt-8 pr-8 pl-5"
                            flat
                            @click="showChart(chart.id)"
                            rounded
                        >
                            <chart-canvas
                                :mode="mode"
                                :chart="chart"
                            ></chart-canvas>
                            <v-card-text
                                v-text="chart.title"
                                class="text-center font-weight-medium"
                            >
                            </v-card-text>
                        </v-card>
                    </v-hover>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import chartCanvas from "../preview/chart";
import Chart from "../globalSettings";
export default {
    props: ["bus"],
    components: {
        chartCanvas
    },
    data: () => ({
        collection: {
            title: ""
        },
        norecords: false,
        loaded: false,
        mode: "thumbnail",
        chartdata: null
    }),
    methods: {
        async getCharts() {
            this.loaded = false;
            try {
                let chartList = await axios.get(
                    "chart/collection/" + this.$route.params.collection
                );
                let dataCollection = chartList.data.charts;

                this.collection.title = chartList.data.name;

                dataCollection.forEach(e => {
                    e.chartdata = JSON.parse(e.chartdata);
                    e.chartoptions = JSON.parse(e.chartoptions);
                });
                this.chartdata = chartList.data.charts;
                if (!dataCollection || dataCollection < 1) {
                    this.norecords = true;
                }
                this.loaded = true;
            } catch (e) {
                console.error(e);
            }
        },
        back() {
            this.loaded = false;
            setTimeout(() => {
                this.$router.push({ name: "charts" });
            }, 100);
        },
        showChart(id) {
            this.loaded = false;
            setTimeout(() => {
                this.$router.push({
                    name: "chartView",
                    params: {
                        collection: this.$route.params.collection,
                        id: id
                    }
                });
            }, 100);
        }
    },
    mounted() {
        this.getCharts();
        // this.bus.$on("companyChange", this.back);
        // this.bus.$on("closeDialog", this.getCharts);
    },
    created() {}
};
</script>
