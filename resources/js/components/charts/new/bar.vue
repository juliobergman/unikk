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
                                <!-- <v-combobox
                                    label="Labels"
                                    multiple
                                    small-chips
                                    v-model="chart.labels"
                                    item-color="primary"
                                >
                                </v-combobox> -->

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
                                <!--  -->
                                <!-- Options -->
                                <v-row no-gutters class="mb-5">
                                    <v-col class="d-flex justify-center pa-1">
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    icon
                                                    x-small
                                                    value="bar"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="
                                                        destroyDataSet(index)
                                                    "
                                                >
                                                    <v-icon small
                                                        >mdi-delete</v-icon
                                                    >
                                                </v-btn>
                                            </template>
                                            <span>Delete Data Set</span>
                                        </v-tooltip>
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
                                                                        .backgroundColor
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
                                                                    .backgroundColor
                                                            "
                                                            @update:color="
                                                                updateChart()
                                                            "
                                                        >
                                                        </v-color-picker>
                                                    </v-menu>
                                                </v-fade-transition>
                                            </template>
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
                                                    label="Y Stacked"
                                                    hide-details
                                                ></v-checkbox>
                                                <v-checkbox
                                                    dense
                                                    v-model="
                                                        options.scales.xAxes[0]
                                                            .stacked
                                                    "
                                                    label="X Stacked"
                                                    hide-details
                                                ></v-checkbox>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" class="d-flex justify-end">
                                        <v-btn
                                            color="primary"
                                            @click="updateOptions()"
                                        >
                                            Update
                                            <v-icon small class="ml-2"
                                                >mdi-update</v-icon
                                            >
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
                    type="barChart"
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
        loaded: false,
        valid: true,
        sMaxTextField: false,
        sMinTextField: false,
        tempColor: "#3737FF99",
        chartType: "barChart",
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

            return labels;
        },
        chartData() {
            let cLabels = this.processLabels(this.chart.labels);
            return {
                labels: cLabels,
                datasets: this.chart.datasets
            };
        },
        addDataSet() {
            let ds = this.chart.datasets.length;
            let newDataSet = {
                label: "Data " + (ds + 1),
                backgroundColor: this.$vuetify.theme.currentTheme
                    .qualitativePalette[ds],
                data: []
            };
            this.chart.datasets = [...this.chart.datasets, newDataSet];
        },
        destroyDataSet(e) {
            if (this.chart.datasets[e]) {
                this.chart.datasets.splice(e, 1);
            }
        },
        updateChart() {
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
                backgroundColor: this.$vuetify.theme.currentTheme
                    .qualitativePalette[0],
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
                        stacked: false,
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
