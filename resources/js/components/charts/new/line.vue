<template>
    <div>
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>
        <v-row>
            <v-col cols="12" md="6" order="1" order-md="0" class="mt-md-5">
                <v-form v-model="valid">
                    <!-- Form -->
                    <v-container>
                        <v-row>
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
                                <!-- Options -->
                                <v-row no-gutters class="mb-5">
                                    <v-col class="d-flex justify-center">
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    icon
                                                    small
                                                    value="bar"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="
                                                        destroyDataSet(index)
                                                    "
                                                >
                                                    <v-icon>
                                                        mdi-delete
                                                    </v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Delete Data Set</span>
                                        </v-tooltip>
                                    </v-col>
                                    <v-col class="d-flex justify-center">
                                        <v-fade-transition leave-absolute>
                                            <v-menu
                                                :close-on-content-click="false"
                                                :offset-y="true"
                                            >
                                                <template
                                                    v-slot:activator="{
                                                        on,
                                                        attrs
                                                    }"
                                                >
                                                    <v-btn
                                                        small
                                                        icon
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        class="mr-2"
                                                    >
                                                        <v-icon>
                                                            mdi-cog
                                                        </v-icon>
                                                    </v-btn>
                                                </template>
                                                <v-card min-width="237">
                                                    <!-- Border Width -->
                                                    <v-card-text
                                                        class="border-bottom"
                                                    >
                                                        <span>
                                                            Border Width
                                                        </span>
                                                        <v-slider
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].borderWidth
                                                            "
                                                            hide-details
                                                            max="10"
                                                            min="0"
                                                            step="1"
                                                        ></v-slider>
                                                    </v-card-text>
                                                    <!-- Point Radius -->
                                                    <v-card-text
                                                        class="border-bottom"
                                                    >
                                                        <span>
                                                            Point Radius
                                                        </span>
                                                        <v-slider
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].pointRadius
                                                            "
                                                            hide-details
                                                            max="15"
                                                            min="0"
                                                            step="1"
                                                        ></v-slider>
                                                    </v-card-text>
                                                    <!-- Tension -->
                                                    <v-card-text
                                                        class="border-bottom"
                                                    >
                                                        <span>
                                                            Tension
                                                        </span>
                                                        <v-slider
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].tension
                                                            "
                                                            hide-details
                                                            max="1"
                                                            min="0"
                                                            step="0.01"
                                                        ></v-slider>
                                                    </v-card-text>
                                                    <!-- Border Dash -->
                                                    <v-card-text
                                                        class="border-bottom"
                                                    >
                                                        <div
                                                            class="text-center mb-1 subtitle-2"
                                                        >
                                                            Border Dash
                                                        </div>
                                                        <span>
                                                            Line
                                                        </span>
                                                        <v-slider
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].borderDash[0]
                                                            "
                                                            hide-details
                                                            max="20"
                                                            min="0"
                                                            step="0.1"
                                                        ></v-slider>
                                                        <span>
                                                            Gap
                                                        </span>
                                                        <v-slider
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].borderDash[1]
                                                            "
                                                            hide-details
                                                            max="20"
                                                            min="0"
                                                            step="0.1"
                                                        ></v-slider>
                                                    </v-card-text>
                                                    <!-- Checkboxes -->
                                                    <v-card-text>
                                                        <v-checkbox
                                                            dense
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].fill
                                                            "
                                                            label="Filled"
                                                            hide-details
                                                        ></v-checkbox>

                                                        <v-checkbox
                                                            dense
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].spanGaps
                                                            "
                                                            label="Span Gaps"
                                                            hide-details
                                                        ></v-checkbox>

                                                        <v-checkbox
                                                            dense
                                                            v-model="
                                                                chart.datasets[
                                                                    index
                                                                ].showLine
                                                            "
                                                            label="Show Line"
                                                            hide-details
                                                        ></v-checkbox>
                                                    </v-card-text>
                                                </v-card>
                                            </v-menu>
                                        </v-fade-transition>
                                    </v-col>
                                    <v-col class="d-flex justify-center">
                                        <v-fade-transition leave-absolute>
                                            <v-menu
                                                :close-on-content-click="false"
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
                                                            chart.datasets[
                                                                index
                                                            ].borderColor
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
                                                        chart.datasets[index]
                                                            .borderColor
                                                    "
                                                    @update:color="
                                                        updateChart(index)
                                                    "
                                                >
                                                </v-color-picker>
                                            </v-menu>
                                        </v-fade-transition>
                                    </v-col>
                                </v-row>
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
                                <strong>Chart Options</strong>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-row>
                                    <v-col cols="12" class="pt-3">
                                        <v-text-field
                                            dense
                                            label="Title"
                                            v-model="options.title.text"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <v-row no-gutters>
                                            <v-col
                                                cols="12"
                                                class="d-flex justify-center"
                                            >
                                                <div>
                                                    <div
                                                        class="text-center mb-2"
                                                    >
                                                        Legend Position
                                                    </div>
                                                    <v-btn-toggle
                                                        color="accent"
                                                        tile
                                                        group
                                                        v-model="
                                                            options.legend
                                                                .position
                                                        "
                                                        mandatory
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
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters class="mt-4">
                                            <v-col cols="10">
                                                <v-text-field
                                                    v-model="
                                                        options.scales.yAxes[0]
                                                            .ticks.suggestedMax
                                                    "
                                                    :disabled="!sMaxTextField"
                                                    label="Suggested Max"
                                                    type="number"
                                                >
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="2">
                                                <v-checkbox
                                                    @change="
                                                        checkSuggested('max')
                                                    "
                                                    v-model="sMaxTextField"
                                                    dense
                                                    hide-details
                                                ></v-checkbox>
                                            </v-col>
                                            <v-col cols="10">
                                                <v-text-field
                                                    v-model="
                                                        options.scales.yAxes[0]
                                                            .ticks.suggestedMin
                                                    "
                                                    :disabled="!sMinTextField"
                                                    label="Suggested Min"
                                                    type="number"
                                                >
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="2">
                                                <v-checkbox
                                                    @change="
                                                        checkSuggested('min')
                                                    "
                                                    v-model="sMinTextField"
                                                    dense
                                                    hide-details
                                                ></v-checkbox>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-row no-gutters>
                                            <v-col cols="12">
                                                <v-checkbox
                                                    dense
                                                    v-model="
                                                        options.title.display
                                                    "
                                                    label="Display Title"
                                                    hide-details
                                                ></v-checkbox>
                                                <v-checkbox
                                                    dense
                                                    v-model="
                                                        options.legend.display
                                                    "
                                                    label="Display Legend"
                                                    hide-details
                                                ></v-checkbox>
                                                <v-checkbox
                                                    dense
                                                    v-model="
                                                        options.scales.yAxes[0]
                                                            .stacked
                                                    "
                                                    label="Stacked"
                                                    hide-details
                                                ></v-checkbox>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" class="d-flex justify-end">
                                        <v-btn text @click="updateOptions()">
                                            <v-icon small class="mr-2">
                                                mdi-update
                                            </v-icon>
                                            Update
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
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
                    type="lineChart"
                    :chart-data="chartData()"
                    :options="options"
                    :bus="bus"
                ></chart-canvas>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import chartCanvas from "../build/chart";
import { processLabels } from "./fun";
let labels = [];
let dataSets = [];
let dataOptions = {};

export default {
    props: ["bus", "id"],
    components: {
        chartCanvas
    },
    data: () => ({
        collection: null,
        loaded: true,
        valid: true,
        sMaxTextField: false,
        sMinTextField: false,
        tempColor: "#3737FF99",
        chartType: "lineChart",
        info: "",
        chart: {},
        options: {}
    }),
    methods: {
        chartData() {
            // Labels
            let cLabels = processLabels(this.chart.labels);
            return {
                labels: cLabels,
                datasets: this.chart.datasets
            };
        },
        processColor(color) {
            color = color.slice(0, -2);
            color = color + "40";
            return color;
        },
        addDataSet() {
            let ds = this.chart.datasets.length;
            let color = this.$vuetify.theme.currentTheme.qualitativePalette[ds];
            let newDataSet = {
                label: "Data " + (ds + 1),
                backgroundColor: this.processColor(color),
                borderColor: color,
                pointBackgroundColor: color,
                borderWidth: 3,
                fill: false,
                tension: 0.3,
                spanGaps: true,
                borderDash: [0, 0],
                showLine: true,
                pointRadius: 3,
                data: []
            };
            this.chart.datasets = [...this.chart.datasets, newDataSet];
        },
        destroyDataSet(e) {
            if (this.chart.datasets[e]) {
                this.chart.datasets.splice(e, 1);
            }
        },
        updateChart(index) {
            let color = this.chart.datasets[index].borderColor;
            this.chart.datasets[index].pointBackgroundColor = color;
            this.chart.datasets[index].backgroundColor = this.processColor(
                color
            );
            this.bus.$emit("updateChart");
        },
        updateOptions() {
            this.bus.$emit("updateOptions");
        },
        checkSuggested(e) {
            if (e === "max") {
                if (!this.sMaxTextField) {
                    this.options.scales.yAxes[0].ticks.suggestedMax = undefined;
                }
            }
            if (e === "min") {
                if (!this.sMinTextField) {
                    this.options.scales.yAxes[0].ticks.suggestedMin = undefined;
                }
            }
        },
        saveChart() {
            let datasets = {};

            this.chart.datasets.forEach((e, index) => {
                datasets[index] = {
                    label: e.label,
                    backgroundColor: e.backgroundColor,
                    borderColor: e.borderColor,
                    pointBackgroundColor: e.pointBackgroundColor,
                    borderWidth: e.borderWidth,
                    fill: e.fill,
                    tension: e.tension,
                    spanGaps: e.spanGaps,
                    borderDash: e.borderDash,
                    showLine: e.showLine,
                    pointRadius: e.pointRadius,
                    data: e.data
                };
            });

            let chartdata = {
                labels: processLabels(this.chart.labels),
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
                backgroundColor: "#3737FF33",
                borderColor: "#3737FF99",
                pointBackgroundColor: "#3737FF99",
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                spanGaps: true,
                borderDash: [0, 0],
                showLine: true,
                pointRadius: 3,
                data: []
            }
        ];

        dataOptions = {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: true,
                text: "Mock Up Text",
                fontSize: 16
            },
            legend: {
                display: true,
                position: "bottom"
            },
            scales: {
                xAxes: [
                    {
                        ticks: {
                            display: true
                        }
                    }
                ],
                yAxes: [
                    {
                        stacked: false,
                        ticks: {
                            display: true,
                            suggestedMin: undefined,
                            suggestedMax: undefined
                        }
                    }
                ]
            }
        };

        this.chart = {
            labels: labels,
            datasets: dataSets
        };

        this.options = dataOptions;

        // Update Data
        if (this.id) {
            let chart_id = this.id;
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
                    this.info = response.data.info;
                })
                .catch(error => {
                    console.log(error);
                });
        }

        setTimeout(() => {
            this.loaded = true;
        }, 500);
    },
    mounted() {
        if (this.bus) {
            this.bus.$on("addDataSet", this.addDataSet);
            this.bus.$on("saveChart", this.saveChart);
        }
    }
};
</script>

<style></style>
