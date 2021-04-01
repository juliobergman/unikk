<template>
    <v-main>
        <v-toolbar elevation="2" dense>
            <v-btn-toggle mandatory tile group v-model="chartType">
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn value="barChart" v-bind="attrs" v-on="on">
                            <v-icon>mdi-chart-bar</v-icon>
                        </v-btn>
                    </template>
                    <span>Bar Chart</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn value="lineChart" v-bind="attrs" v-on="on">
                            <v-icon>mdi-chart-areaspline-variant</v-icon>
                        </v-btn>
                    </template>
                    <span>Line Chart</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn value="pieChart" v-bind="attrs" v-on="on">
                            <v-icon>mdi-chart-pie</v-icon>
                        </v-btn>
                    </template>
                    <span>Pie Chart</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn value="doughnutChart" v-bind="attrs" v-on="on">
                            <v-icon>mdi-chart-donut</v-icon>
                        </v-btn>
                    </template>
                    <span>Doughnut Chart</span>
                </v-tooltip>
            </v-btn-toggle>
            <v-spacer></v-spacer>
            <v-btn @click="testFunction()" text color="grey darken-3">
                SYNC
            </v-btn>
            <v-btn @click="addDataSet()" text color="grey darken-3">
                Add Data Set
            </v-btn>
            <v-btn text color="grey darken-3">
                SAVE
                <v-icon class="ml-2">mdi-content-save</v-icon>
            </v-btn>
        </v-toolbar>

        <v-container fluid>
            <v-row>
                <v-col cols="12" md="6" order="1" order-md="0">
                    <v-form v-model="valid">
                        <!-- Form -->
                        <v-row>
                            <v-col cols="12"
                                ><v-text-field
                                    dense
                                    label="Title"
                                    v-model="options.title.text"
                                ></v-text-field
                            ></v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="chart.labels"
                                    dense
                                    label="Labels"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <!-- Data Sets -->

                        <!-- Options -->
                        <v-row no-gutters class="mb-5">
                            <v-col
                                v-for="(dataset, index) in chart.datasets"
                                :key="index"
                                class="d-flex justify-center pa-1"
                            >
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            block
                                            x-small
                                            value="bar"
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <v-icon small>mdi-delete</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Delete Data Set</span>
                                </v-tooltip>
                            </v-col>
                        </v-row>
                        <!-- Name -->
                        <v-row no-gutters>
                            <v-col
                                v-for="(dataset, index) in chart.datasets"
                                :key="index"
                            >
                                <v-text-field
                                    v-model="chart.datasets[index].label"
                                    dense
                                    label="Name"
                                >
                                    <template v-slot:append>
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
                                                            ].backgroundColor
                                                        "
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        x-small
                                                        class="mr-2"
                                                    >
                                                    </v-btn>
                                                </template>
                                                <v-color-picker
                                                    show-swatches
                                                    class="ma-3"
                                                    mode="rgba"
                                                    v-model="
                                                        chart.datasets[index]
                                                            .backgroundColor
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
                            <v-col
                                v-for="(dataset, index) in chart.datasets"
                                :key="index"
                            >
                                <v-text-field
                                    v-for="(item, i) in chartData().labels"
                                    :key="i"
                                    hide-details="true"
                                    dense
                                    class="mb-3"
                                    label=""
                                    v-model.number="
                                        chart.datasets[index].data[i]
                                    "
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <!-- Options Container -->

                        <v-row no-gutters>
                            <v-col cols="12">
                                <options-canvas
                                    v-on:reloadchart="setOptions"
                                    :type="chartType"
                                ></options-canvas>
                            </v-col>
                        </v-row>

                        <!-- /Form -->
                    </v-form>
                </v-col>
                <v-col cols="12" md="6" order="0" order-md="1">
                    <chart-canvas
                        :type="chartType"
                        :chart-data="chartData()"
                        :options="chartOptions()"
                    ></chart-canvas>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import chartCanvas from "./type/chart";
import optionsCanvas from "./options/options";

//chartCanvas.defaults.global.defaultFontFamily = "Nunito";
//chartCanvas.defaults.global.defaultFontColor = "#404649";
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
    components: {
        chartCanvas,
        optionsCanvas
    },
    data: () => ({
        valid: true,
        defaultColor: "#3737FF99",
        chartType: "barChart",
        options: {
            title: {
                text: ""
            }
        },
        chart: {
            labels: Labels,
            datasets: DataSets
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
        setOptions(e) {
            this.options = e;
        },
        chartOptions() {
            return this.options;
        },
        addDataSet() {
            this.chart.datasets.push({
                label: "Data",
                backgroundColor: this.defaultColor,
                data: []
            });
        },
        destroyDataSet(e) {
            if (this.chart.datasets[e]) {
                this.chart.datasets.splice(this.chart.datasets.indexOf(e), 1);
            }
        },
        saveChart() {
            console.log("Call Save Chart Function");
        },
        testFunction() {
            console.log("testFunction");
            console.log(this.options);
        }
    },
    watch: {
        chartType(e) {
            if (e === "lineChart" || e === "barChart") {
                this.chart.datasets.forEach(elem => {
                    elem.backgroundColor = "";
                    elem.backgroundColor = this.defaultColor;
                });
            }
            if (e === "pieChart" || e === "doughnutChart") {
                this.chart.datasets.forEach(elem => {
                    elem.backgroundColor = [];
                    elem.data.forEach((bc, index) => {
                        elem.backgroundColor[index] = this.defaultColor;
                    });
                });
            }
        },
        options(e) {
            console.log(e);
        }
    },
    created() {
        console.log(this.options);
    }
};
</script>

<style scoped></style>
