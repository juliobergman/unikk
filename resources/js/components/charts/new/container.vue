<template>
    <v-card color="background">
        <v-toolbar
            class="main-gradient mb-5"
            elevation="2"
            dark
            dense
            rounded="0"
        >
            <v-btn-toggle group mandatory v-model="chartEditor">
                <v-tooltip bottom v-for="item in chartMenu" :key="item.title">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            :disabled="type && item.to != type"
                            :value="item.to"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon> {{ item.icon }}</v-icon>
                        </v-btn>
                    </template>
                    <span>{{ item.title }}</span>
                </v-tooltip>
            </v-btn-toggle>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn-toggle group>
                <v-tooltip bottom v-for="(item, idx) in toolsMenu" :key="idx">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            :disabled="
                                item.action == 'addDataSet' &&
                                    chartEditor == 'pieChart'
                            "
                            @click="busEmmit(item.action)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon> {{ item.icon }} </v-icon>
                        </v-btn>
                    </template>
                    <span>{{ item.tooltip }}</span>
                </v-tooltip>
            </v-btn-toggle>
        </v-toolbar>

        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <v-select
                        prepend-icon="mdi-folder"
                        v-model="collection"
                        :items="folders"
                        item-text="name"
                        item-value="id"
                        label=""
                    ></v-select>
                </v-col>
            </v-row>
        </v-container>

        <v-container v-if="chartEditor == 'barChart'" fluid>
            <bar-chart
                :bus="bus"
                :id="id"
                v-on:savechart.capture="storeChart($event)"
            ></bar-chart>
        </v-container>

        <v-container v-if="chartEditor == 'lineChart'" fluid>
            <line-chart
                :bus="bus"
                :id="id"
                v-on:savechart.capture="storeChart($event)"
            ></line-chart>
        </v-container>

        <v-container v-if="chartEditor == 'pieChart'" fluid>
            <pie-chart
                :bus="bus"
                :id="id"
                v-on:savechart.capture="storeChart($event)"
            ></pie-chart>
        </v-container>
    </v-card>
</template>

<script>
import barChart from "./bar";
import lineChart from "./line";
import pieChart from "./pie";
export default {
    components: { barChart, lineChart, pieChart },
    props: ["bus", "id", "type"],
    data: () => ({
        chartEditor: null,
        collection: null,
        folders: [],
        toolsMenu: [
            {
                tooltip: "Add New Data Set",
                icon: "mdi-chart-box-plus-outline",
                action: "addDataSet"
            },
            {
                tooltip: "Save Chart",
                icon: "mdi-content-save",
                action: "saveChart"
            },
            {
                tooltip: "Close",
                icon: "mdi-close",
                action: "closeDialog"
            }
        ],
        chartMenu: [
            {
                title: "New Bar Chart",
                icon: "mdi-chart-bar",
                to: "barChart"
            },
            {
                title: "New Line Chart",
                icon: "mdi-chart-areaspline-variant",
                to: "lineChart"
            },
            {
                title: "New Pie Chart",
                icon: "mdi-chart-pie",
                to: "pieChart"
            }
        ]
    }),
    methods: {
        storeChart(data) {
            data.collection = this.collection;

            if (!this.id) {
                axios
                    .post("chart/store", data)
                    .then(response => {
                        // console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }

            if (this.id) {
                axios
                    .put("chart/" + this.id, data)
                    .then(response => {})
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        busEmmit($action) {
            this.bus.$emit($action);
        }
    },
    created() {
        axios
            .get("chart/collections/" + localStorage.getItem("company"))
            .then(response => {
                this.folders = response.data;
            })
            .catch(response => {});

        // Collection
        if (!this.collection) {
            let collectionId = Number.parseInt(
                this.$route.params.collection,
                10
            );
            this.collection = collectionId;
        }
    },
    mounted() {
        // this.getFolders();
        // if (this.$route.name === "newchart") {
        //     this.$router.push({ name: "newbarchart" });
        // }
        // this.currentRoute = this.$route.name;
    }
};
</script>

<style scoped></style>
