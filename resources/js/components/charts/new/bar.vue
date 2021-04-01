<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="6" order="1" order-md="0" class="mt-md-5">
                <v-form v-model="valid">
                    <!-- Form -->
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="chart.labels"
                                dense
                                label="Labels"
                            ></v-text-field>
                        </v-col>
                    </v-row>
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
                                                    block
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
                                                                x-small
                                                                class="mr-2"
                                                            >
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
                    <v-expansion-panels>
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
    </v-container>
</template>

<script>
import chartCanvas from "../type/chart";

let Labels = ["Jan", "Feb", "Mar"];
let DataSets = [
    {
        label: "Data 1",
        backgroundColor: "#3737FF99",
        data: [20, 40, 60]
    },
    {
        label: "Data 2",
        backgroundColor: "#FF373799",
        data: [15, 35, 25]
    }
];

export default {
    props: ["bus"],
    components: {
        chartCanvas
    },
    data: () => ({
        valid: true,
        sMaxTextField: false,
        sMinTextField: false,
        tempColor: "#3737FF99",
        chartType: "barChart",
        chart: {
            labels: Labels,
            datasets: DataSets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: "Chart Title",
                fontSize: 16
            },
            legend: {
                display: true,
                position: "bottom"
            },
            scales: {
                xAxes: [
                    {
                        stacked: false
                    }
                ],
                yAxes: [
                    {
                        stacked: false,
                        ticks: {
                            suggestedMin: undefined,
                            suggestedMax: undefined
                        }
                    }
                ]
            }
        }
    }),
    methods: {
        chartData() {
            // Labels
            if (typeof this.chart.labels === "string") {
                // Check if is String
                Labels = this.chart.labels.split(","); // Split to Array by
            }

            Labels = Labels.map(function(e) {
                // Trim the array Object
                return e.trim();
            });
            Labels = Labels.filter(el => {
                // Remove empty
                return el != null && el != "";
            });

            return {
                labels: Labels,
                datasets: DataSets
            };
        },
        addDataSet() {
            this.chart.datasets.push({
                label: "Data",
                backgroundColor: this.tempColor,
                data: []
            });
        },
        destroyDataSet(e) {
            if (this.chart.datasets[e]) {
                this.chart.datasets.splice(this.chart.datasets.indexOf(e), 1);
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
                labels: this.chart.labels,
                datasets: datasets
            };

            let saveData = {
                title: this.options.title.text,
                chartdata: JSON.stringify(chartdata),
                chartoptions: JSON.stringify(this.options),
                charttype: this.chartType
            };
        }
    },
    mounted() {
        this.bus.$on("addDataSet", this.addDataSet);
        this.bus.$on("saveChart", this.saveChart);
    }
};
</script>

<style></style>
