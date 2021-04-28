<template>
    <v-card class="p-2">
        <!-- <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay> -->
        <v-row>
            <v-col cols="12" md="6" order="1" order-md="0" class="mt-md-5">
                <v-form v-model="valid">
                    <!-- Form -->
                    <v-container>
                        <v-row>
                            <v-col cols="12" class="d-flex">
                                <v-text-field
                                    @keypress.enter="updateOptions()"
                                    v-model="options.title.text"
                                    dense
                                    label="Chart Title"
                                >
                                </v-text-field>
                                <v-fade-transition leave-absolute>
                                    <v-menu :close-on-content-click="false">
                                        <template
                                            v-slot:activator="{
                                                on,
                                                attrs
                                            }"
                                        >
                                            <v-btn
                                                v-bind="attrs"
                                                v-on="on"
                                                absolute
                                                right
                                                small
                                                plain
                                                class="ml-3"
                                            >
                                                <v-icon>
                                                    mdi-cog
                                                </v-icon>
                                            </v-btn>
                                        </template>
                                        <v-card min-width="237">
                                            <!-- Checkboxes -->
                                            <v-card-text>
                                                <v-checkbox
                                                    @change="updateOptions()"
                                                    dense
                                                    v-model="
                                                        options.title.display
                                                    "
                                                    label="Display Title"
                                                    hide-details
                                                ></v-checkbox>
                                                <v-checkbox
                                                    @change="updateOptions()"
                                                    dense
                                                    v-model="
                                                        options.legend.display
                                                    "
                                                    label="Display Legend"
                                                    hide-details
                                                ></v-checkbox>
                                            </v-card-text>
                                            <!-- Border Width -->
                                            <v-card-text class="border-bottom">
                                                <span>
                                                    Border Width
                                                </span>
                                                <v-slider
                                                    v-model="
                                                        chart.datasets[0]
                                                            .borderWidth
                                                    "
                                                    hide-details
                                                    max="10"
                                                    min="0"
                                                    step="1"
                                                ></v-slider>
                                            </v-card-text>
                                            <v-card-text>
                                                <div class="mb-2">
                                                    Legend Position
                                                </div>
                                                <v-btn-toggle
                                                    v-model="
                                                        options.legend.position
                                                    "
                                                    mandatory
                                                    @change="updateOptions()"
                                                >
                                                    <v-btn value="left">
                                                        <v-icon>
                                                            mdi-format-horizontal-align-left
                                                        </v-icon>
                                                    </v-btn>
                                                    <v-btn value="top">
                                                        <v-icon>
                                                            mdi-format-vertical-align-top
                                                        </v-icon>
                                                    </v-btn>
                                                    <v-btn value="bottom">
                                                        <v-icon>
                                                            mdi-format-vertical-align-bottom
                                                        </v-icon>
                                                    </v-btn>
                                                    <v-btn value="right">
                                                        <v-icon>
                                                            mdi-format-horizontal-align-right
                                                        </v-icon>
                                                    </v-btn>
                                                </v-btn-toggle>
                                            </v-card-text>
                                        </v-card>
                                    </v-menu>
                                </v-fade-transition>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="chart.labels"
                                    dense
                                    label="Labels"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                    <!-- Data Sets -->
                    <v-container>
                        <v-row dense>
                            <v-col
                                v-for="(dataset, index) in chart.datasets"
                                :key="index"
                            >
                                <!-- Name -->
                                <v-row no-gutters>
                                    <v-col>
                                        <v-text-field
                                            v-model="
                                                chart.datasets[index].label
                                            "
                                            dense
                                            label="Name"
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <!-- Listing Data Set -->
                                <v-row no-gutters>
                                    <v-col>
                                        <v-text-field
                                            v-for="(item, i) in chartData()
                                                .labels"
                                            :key="i"
                                            hide-details="true"
                                            dense
                                            class="mb-3"
                                            label=""
                                            v-model.number="
                                                chart.datasets[index].data[i]
                                            "
                                            type="number"
                                        >
                                            <!-- Color Picler -->
                                            <template v-slot:append>
                                                <v-fade-transition
                                                    leave-absolute
                                                >
                                                    <v-menu
                                                        :close-on-content-click="
                                                            false
                                                        "
                                                        :offset-y="true"
                                                    >
                                                        <template
                                                            v-slot:activator="{
                                                                on,
                                                                attrs
                                                            }"
                                                        >
                                                            <v-btn
                                                                :color="
                                                                    chart
                                                                        .datasets[
                                                                        index
                                                                    ]
                                                                        .backgroundColor[
                                                                        i
                                                                    ]
                                                                "
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                small
                                                                icon
                                                            >
                                                                <v-icon>
                                                                    mdi-checkbox-blank-circle
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <v-color-picker
                                                            class="ma-3"
                                                            mode="rgba"
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ]
                                                                    .backgroundColor[
                                                                    i
                                                                ]
                                                            "
                                                            @update:color="
                                                                updateChart()
                                                            "
                                                        >
                                                        </v-color-picker>
                                                    </v-menu>
                                                </v-fade-transition>
                                            </template>
                                            <!-- / Color Picker -->
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <!--  -->
                            </v-col>
                        </v-row>
                    </v-container>
                    <!-- Options Container -->
                    <v-expansion-panels flat>
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                <strong>Comments</strong>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-textarea
                                    label="Comments"
                                    hide-details
                                    v-model="info"
                                ></v-textarea>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                    <!-- /Form -->
                </v-form>
            </v-col>
            <v-col cols="12" md="6" order="0" order-md="1">
                <chart-canvas
                    type="pieChart"
                    :chart-data="chartData()"
                    :options="options"
                    :bus="bus"
                ></chart-canvas>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import chartCanvas from "../build/chart";
let labels = [];
let dataSets = [];
let dataOptions = {};

export default {
    props: ["bus"],
    components: {
        chartCanvas
    },
    data: () => ({
        loaded: true,
        valid: true,
        chartType: "pieChart",
        info: "",
        chart: {},
        options: {}
    }),
    methods: {
        processLabels(labels) {
            if (typeof labels === "string") {
                // Check if is String
                labels = labels.split(","); // Split to Array by
            }

            labels = labels.map(function(e) {
                // Trim the array Object
                return e.trim();
            });
            labels = labels.filter(el => {
                // Remove empty
                return el != null && el != "";
            });
            labels.forEach((e, i) => {
                if (!this.chart.datasets[0].backgroundColor[i]) {
                    this.chart.datasets[0].backgroundColor[
                        i
                    ] = this.$vuetify.theme.currentTheme.qualitativePalette[i];
                }
            });

            return labels;
        },
        chartData() {
            // Labels
            labels = this.processLabels(this.chart.labels);

            return {
                labels: labels,
                datasets: dataSets
            };
        },
        updateChart() {
            this.bus.$emit("updateChart");
        },
        updateOptions() {
            this.bus.$emit("updateOptions");
        },
        saveChart() {
            let datasets = {};

            this.chart.datasets.forEach((e, index) => {
                datasets[index] = {
                    label: e.label,
                    backgroundColor: e.backgroundColor,
                    borderWidth: e.borderWidth,
                    data: e.data
                };
            });

            let chartdata = {
                labels: this.processLabels(this.chart.labels),
                datasets: datasets
            };

            let saveData = {
                title: this.options.title.text,
                info: this.info,
                chartdata: chartdata,
                chartoptions: this.options,
                type: this.chartType
            };

            this.$emit("savechart", saveData);
        }
    },
    created() {
        this.loaded = false;
        // Defaults
        labels = [];
        dataSets = [
            {
                label: "Data",
                backgroundColor: [],
                borderWidth: 3,
                data: []
            }
        ];

        dataOptions = {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: true,
                text: "Pie Chart",
                fontSize: 16
            },
            legend: {
                display: true,
                position: "bottom"
            }
        };

        this.chart = {
            labels: labels,
            datasets: dataSets
        };

        this.options = dataOptions;

        // Update Data
        if (this.$route.params.id) {
            let chart_id = this.$route.params.id;

            axios
                .get("chart/" + chart_id)
                .then(response => {
                    this.chartType = response.data.type;
                    labels = response.data.chartdata.labels;
                    dataSets = response.data.chartdata.datasets;
                    dataOptions = response.data.chartoptions;
                    this.chart = {
                        labels: labels,
                        datasets: dataSets
                    };
                    this.options = dataOptions;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.bus.$on("addDataSet", this.addDataSet);
        this.bus.$on("saveChart", this.saveChart);
        this.loaded = true;
    }
};
</script>

<style></style>
