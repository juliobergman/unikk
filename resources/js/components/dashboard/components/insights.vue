<template>
    <v-card flat :outlined="!darkTheme && !print" v-if="loadChart && loaded">
        <v-card-text v-if="false" class="d-none d-print-inline mb-10">
            <v-sheet max-width="30%">
                <img src="factory/stock/default-print-header.png" class="w-100"></img>
            </v-sheet>
            <v-divider></v-divider>
            <v-sheet class="d-flex my-10">
                <span class="print-text-title" v-text="branch.name"></span>
                <v-spacer></v-spacer>
                <span class="print-text-title" v-text="year"></span>
            </v-sheet>
        </v-card-text>
        <v-toolbar class="d-print-none mb-4" color="transparent" flat>
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
                v-if="false"
                v-show="fullscreen"
                class="mr-2"
                small
                icon
                @click="goPrint()"
            >
                <v-icon>
                    {{ pricon }}
                </v-icon>
            </v-btn>
            <v-btn v-show="!print" small icon class="mr-1" @click="goFullScreen()">
                <v-icon>
                    {{ fsicon }}
                </v-icon>
            </v-btn>
        </v-toolbar>
        <v-card-text>
            <div class="print-canvas">
                <chart-canvas
                    v-if="loaded"
                    :height="fscsize"
                    :type="ctype"
                    :chart-data="chartData"
                    :options="coptions"
                    :bus="bus"
                ></chart-canvas>
            </div>
            <v-slider
                class="d-print-none"
                color="blue"
                min="0"
                max="9"
                v-model="zoom"
                step="1"
            >
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
                class="d-print-none"
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
            <span class="subtitle-2 ml-3">
                {{ year }} - {{ branch.name }}
            </span>
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
    props:{
        bus: {},
        darkTheme: {},
        inid: {type: Number, default:21},
        ky: {type: Number, default:1}
    },
    components: { chartCanvas },
    data: () => ({
        loaded: false,
        print: false,
        fullscreen: false,
        selection: "",
        year: new Date().getFullYear(),
        headers: [],
        fields: [],
        yearlist: [],
        zoom: 7,
        zoomPos: 5,
        branch: {},
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
        rvid(){
              return sessionStorage.getItem('rvid');
        },
        loadChart(){
            return (this.apilabels || this.apisets) ? true : false;
        },
        chartData(){
            return (this.apilabels || this.apisets) ? this.cdata() : false;
        },
        fsicon() {
            return this.fullscreen ? "mdi-fullscreen-exit" : "mdi-fullscreen";
        },
        pricon() {
            return this.print ? "mdi-close" : "mdi-printer";
        },
        fscsize() {

            return this.fullscreen ? 430 : 585;

            // if(this.fullscreen){
            //     return 430;
            // } else {
            //     return 585;
            // }
            // if(this.print){
            //     return 768;
            // } else {

            //     return 585;
            // }
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
        getFields() {
            this.loaded.false;
            axios
                .get("result/all")
                .then(response => {
                    if (response.status == 200) {
                        this.fields = response.data;
                        this.branch = response.data.find(e => e.id == this.inid);
                        this.getDataSets(this.branch);
                        this.loaded = true;
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        },
        getYears() {
            this.loaded.false;
            axios
                .get("date/years")
                .then(response => {
                    if (response.status == 200) {
                        this.yearlist = response.data;
                        this.loaded = true;
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        },
        async getDataSets($insight) {
            this.loaded = false;

            if(_.isEmpty($insight)) return;

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
        formatN(value, format) {
            return formatLabel(value, format, false);
            // return 0;
        },
        goFullScreen() {
            this.fullscreen = !this.fullscreen;
            if(!this.fullscreen){
                this.print = false;
                this.bus.$emit("print:on", false);
            }
            this.bus.$emit("insights:fullscreen", {fullscreen: this.fullscreen,  ky: this.ky});
        },
        goPrint() {
            this.print = !this.print;
            this.bus.$emit("print:on", this.print);
        }
    },
    created() {
        this.getFields();
        this.getYears();
    },
    mounted(){
        this.bus.$on("insights:fullscreen", (fs) => {
            if (fs.ky != this.ky) {
                this.fullscreen = false;
            }
        });
        this.bus.$on("companyChange", () => {
            this.loaded = false;
            this.getDataSets(this.branch);
        });
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
<style scoped>
@media print {
    canvas.chart-canvas {
        min-height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        height: auto!important;
        width: auto!important;
    }
    * {
    color:  #232323 !important;
    }
}
.print-text-title {
    font-size: 1.15rem;
    font-weight: 700;
}
</style>
