<template>
    <v-card flat :outlined="!darkTheme">
        <v-toolbar class="mb-4" color="transparent" flat>
            <v-select
                solo
                flat
                v-model="branch"
                :items="fields"
                append-icon=""
                item-text="name"
                hide-details
                @change="getDataSets(branch)"
                return-object
            >
                <template v-slot:selection="{ item }">
                    <span
                        class="text-uppercase font-weight-medium primary--text"
                    >
                        {{ item.name }}
                    </span>
                </template>
            </v-select>
            <v-select
                solo
                flat
                append-icon=""
                v-model="year"
                :items="yearlist"
                item-text="year"
                hide-details
                @change="getDataSets(branch)"
            >
                <template v-slot:selection="{ item }">
                    <span
                        class="text-uppercase font-weight-medium primary--text w-100 text-right"
                    >
                        {{ item.year }}
                    </span>
                </template>
            </v-select>
            <v-btn
                v-show="fullscreen"
                class="mr-2"
                small
                icon
                @click="goPrint()"
            >
                <v-icon>
                    mdi-printer
                </v-icon>
            </v-btn>
            <v-btn small icon class="mr-1" @click="goFullScreen()">
                <v-icon>
                    {{ fsicon }}
                </v-icon>
            </v-btn>
        </v-toolbar>
        <v-card-text>
            <div id="print">
                <chart-canvas
                    v-if="loaded"
                    :height="fscsize"
                    :type="ctype"
                    :chart-data="cdata()"
                    :options="coptions"
                    :bus="bus"
                ></chart-canvas>
            </div>
            <v-slider color="blue" min="0" max="9" v-model="zoom" step="1">
                <template v-slot:prepend>
                    <v-icon>
                        mdi-magnify-minus-outline
                    </v-icon>
                </template>
                <template v-slot:append>
                    <v-icon>
                        mdi-magnify-plus-outline
                    </v-icon>
                </template>
            </v-slider>
            <v-slider
                :disabled="this.zoom == 0"
                min="0"
                :max="this.zoom"
                v-model="zoomPos"
                step="1"
            >
                <template v-slot:prepend>
                    <v-icon>
                        mdi-menu-left
                    </v-icon>
                </template>
                <template v-slot:append>
                    <v-icon>
                        mdi-menu-right
                    </v-icon>
                </template>
            </v-slider>
        </v-card-text>
        <v-card-text v-if="fullscreen">
            <span v-text="branch.name" class="subtitle-2 ml-3"></span>
            <v-divider></v-divider>
            <v-data-table
                :loading="!loaded"
                :headers="tableheaders"
                :items="tableitems"
                disable-filtering
                disable-pagination
                disable-sort
                hide-default-footer
                calculate-widths
                class="no-wrap"
                dense
            >
                <template
                    v-for="header in tableheaders"
                    v-slot:[`item.${header.value}`]="{ item, header, value }"
                >
                    <div>
                        <v-spacer></v-spacer>
                        {{ formatN(value, header.format) }}
                    </div>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from "axios";
import chartCanvas from "../../charts/build/chart";
var currency_symbol = "$";
var format = "currency";

const formatLabel = function(value, format, k = true) {
    let tappend = "";
    let input = value;

    if (input === null) {
        return "";
    }
    if (isNaN(input)) {
        return input;
    }

    if (k) {
        if (value > 999) {
            input = value / 1000;
            tappend = "k";
        }
    }

    if (format == "number") {
        return parseFloat(input) + tappend;
    }

    if (format == "percentage") {
        return parseFloat(input) + tappend + "%";
    }
    if (format == "currency") {
        let val = parseFloat(input);
        let currsym = currency_symbol;

        if (val >= 0) {
            return (
                currsym +
                " " +
                val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +
                tappend
            );
        } else {
            let nv = val * -1;
            return (
                currsym +
                " (" +
                nv.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +
                tappend +
                ")"
            );
        }
    }
};

export default {
    props: ["bus", "darkTheme"],
    components: { chartCanvas },
    data: () => ({
        loaded: false,
        fullscreen: false,
        selection: "",
        year: new Date().getFullYear(),
        fields: [],
        yearlist: [],
        zoom: 7,
        zoomPos: 5,
        branch: {
            id: 21,
            name: "Net Income",
            chart: "barChart",
            report_type: "income"
        },
        format: "",
        apilabels: [],
        apisets: [],
        tableheaders: [],
        tableitems: [],
        coptionsBar: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: false,
                text: "",
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
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)"
                        }
                    }
                ],
                yAxes: [
                    {
                        stacked: false,
                        ticks: {
                            callback: function(value, index, labels) {
                                return formatLabel(value, format);
                            },
                            display: true,
                            suggestedMin: undefined,
                            suggestedMax: undefined
                        }
                    }
                ]
            }
        },
        coptionsLine: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: false,
                text: "",
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
                            callback: function(value, index, labels) {
                                return formatLabel(value, format);
                            },
                            display: true,
                            suggestedMin: undefined,
                            suggestedMax: undefined
                        }
                    }
                ]
            }
        },
        coptionsPie: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: false,
                text: "",
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
                            callback: function(value, index, labels) {
                                return formatLabel(value, format);
                            },
                            display: true,
                            suggestedMin: undefined,
                            suggestedMax: undefined
                        }
                    }
                ]
            }
        }
    }),
    computed: {
        fsicon() {
            return this.fullscreen ? "mdi-fullscreen-exit" : "mdi-fullscreen";
        },
        fscsize() {
            return this.fullscreen ? 430 : 585;
        },
        // currency_symbol() {
        //     return this.$store.state.company.company.currency_symbol;
        // },
        ctype() {
            let ct = this.fields.find(o => o.id === this.branch.id);
            if (ct) {
                return ct.chart;
            } else {
                return "barChart";
            }
        },
        repids() {
            if (this.selection == 0) {
                return [1, 2];
            }
            if (this.selection == 1) {
                return [3, 4];
            }
            if (this.selection == 2) {
                return [5, 6];
            }
        },
        coptions() {
            if (this.ctype == "barChart") {
                return this.coptionsBar;
            }
            if (this.ctype == "lineChart") {
                return this.coptionsLine;
            }
            if (this.ctype == "pieChart") {
                return this.coptionsPie;
            }
        }
    },
    methods: {
        getFields() {
            axios
                .get("result/all")
                .then(response => {
                    this.fields = response.data;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        getYears() {
            axios
                .get("date/years")
                .then(response => {
                    this.yearlist = response.data;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        async getDataSets($insight) {
            this.loaded = false;
            let postData = {
                year: 2021,
                company: localStorage.company,
                branch: $insight
            };
            try {
                let axdata = await axios.post("dw/cdata", postData);

                this.apilabels = axdata.data.labels;
                this.apisets = axdata.data.datasets;
                this.tableheaders = axdata.data.tableheaders;
                this.tableitems = axdata.data.tableitems;

                format = axdata.data.format;
                currency_symbol = this.$store.state.company.company
                    .currency_symbol;

                this.loaded = true;
                this.bus.$emit("insights:loaded");
            } catch (e) {
                console.error(e);
            }
        },
        cdata() {
            let start = this.zoomPos;
            let end = this.zoomPos + (12 - this.zoom);
            let labels = this.apilabels.slice(start, end);
            let sets = [];

            let arr = this.apisets;

            arr.forEach((e, i) => {
                sets[i] = {
                    label: arr[i].label,
                    backgroundColor: arr[i].backgroundColor,
                    data: e.data.slice(start, end)
                };
            });

            return {
                labels: labels,
                datasets: sets
            };
        },
        formatN(value, format) {
            return formatLabel(value, format, false);
            // return 0;
        },
        goFullScreen() {
            this.fullscreen = !this.fullscreen;
            this.bus.$emit("insights:fullscreen", this.fullscreen);
        },
        goPrint() {
            this.bus.$emit("app:print", true);
        }
    },
    created() {
        this.bus.$on("companyChange", () => {
            this.loaded = false;
            this.getDataSets(this.branch);
        });
        this.getFields();
        this.getYears();
        this.getDataSets(this.branch);
    },
    watch: {
        fscsize() {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 100);
        }
    }
};
</script>
