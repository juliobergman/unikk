<template>
    <v-card flat :outlined="!darkTheme">
        <v-card-text>
            <v-select
                solo
                flat
                v-model="branch"
                :items="fields"
                item-text="name"
                hide-details
                @change="getDataSets(branch)"
                return-object
            ></v-select>

            <v-divider></v-divider>

            <chart-canvas
                v-if="loaded"
                :type="ctype"
                :chart-data="cdata()"
                :options="coptions"
                :bus="bus"
            ></chart-canvas>
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
                        mdi-arrow-left-drop-circle
                    </v-icon>
                </template>
                <template v-slot:append>
                    <v-icon>
                        mdi-arrow-right-drop-circle
                    </v-icon>
                </template>
            </v-slider>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from "axios";
import chartCanvas from "../../charts/build/chart";
export default {
    props: ["bus"],
    components: { chartCanvas },
    data: () => ({
        loaded: false,
        selection: "",
        year: 2021,
        fields: [],
        zoom: 4,
        zoomPos: 1,
        branch: {
            id: 18,
            name: "Income",
            chart: "barChart",
            report_type: "income"
        },
        apilabels: [],
        apisets: [],
        sets: [],
        coptions: {
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
        darkTheme() {
            return this.$vuetify.theme.dark ? true : false;
        },
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
                this.sets = axdata.data.datasets;
                this.loaded = true;
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
        }
    },
    created() {
        this.bus.$on("companyChange", () => {
            this.loaded = false;
            this.getDataSets(this.branch);
        });
        this.getFields();
        this.getDataSets(this.branch);
    }
};
</script>

<style></style>
