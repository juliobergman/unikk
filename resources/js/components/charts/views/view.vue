<template>
    <v-main>
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>

        <v-toolbar class="mb-6" rounded elevation="2" dense>
            <v-btn icon @click="back($route.params.collection)">
                <v-icon>
                    mdi-chevron-left
                </v-icon>
            </v-btn>
            <v-toolbar-title v-if="false">{{ chart.title }}</v-toolbar-title>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn
                v-if="currentUser.id == chartData.user_id"
                icon
                @click="deleteChart()"
            >
                <v-icon>
                    mdi-delete
                </v-icon>
            </v-btn>
            <v-btn
                v-if="currentUser.id == chartData.user_id"
                icon
                @click="bus.$emit('showDialog')"
            >
                <v-icon>
                    mdi-pencil
                </v-icon>
            </v-btn>
            <v-btn icon @click="snackbar = true">
                <v-icon>
                    mdi-information
                </v-icon>
            </v-btn>
        </v-toolbar>
        <v-container fluid tag="div" class="pa-0" v-if="loaded">
            <v-card elevation="2">
                <v-row>
                    <v-col cols="12" md="4" order="1" order-md="0">
                        <v-card-title> {{ chartData.title }} </v-card-title>
                        <v-card-text> {{ chartData.info }} </v-card-text>
                    </v-col>
                    <v-col cols="12" md="8" order="0" order-md="1">
                        <view-chart
                            :key="key"
                            :bus="bus"
                            :mode="mode"
                            :chart="chartData"
                        ></view-chart>
                    </v-col>
                </v-row>
                <v-system-bar lights-out class="pr-0">
                    <v-icon>mdi-folder</v-icon>
                    <span class="mr-2"> {{ chartData.collection_name }} </span>
                    <v-spacer></v-spacer>
                    <div
                        class="btn-sys-bar rounded px-2"
                        @click="bus.$emit('showUserProfile', chartData.user_id)"
                    >
                        <v-icon>
                            mdi-account
                        </v-icon>
                        <span> {{ chartData.user_name }} </span>
                    </div>
                </v-system-bar>
            </v-card>
        </v-container>

        <v-snackbar left :timeout="-1" v-model="snackbar">
            <div>
                <div class="ma-2">
                    <v-icon>
                        mdi-folder
                    </v-icon>
                    {{ chartData.collection_name }}
                </div>
                <v-divider></v-divider>
                <div class="ma-2">
                    <v-icon>
                        mdi-account
                    </v-icon>
                    {{ chartData.user_name }}
                </div>
                <v-divider></v-divider>
                <div class="ma-2">
                    <strong>Created at:</strong> {{ chartData.created }}
                </div>
                <div class="ma-2">
                    <strong>Last Update:</strong> {{ chartData.updated }}
                </div>
            </div>
            <template v-slot:action="{ attrs }">
                <v-btn small icon v-bind="attrs" @click="snackbar = false">
                    <v-icon small>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>

        <confirm ref="confirm"></confirm>
        <alert ref="alert"></alert>
    </v-main>
</template>

<script>
import viewChart from "../preview/chart";
import confirm from "../../ui/confirm";
import alert from "../../ui/alert";

export default {
    props: ["bus", "id"],
    components: {
        viewChart,
        confirm,
        alert
    },
    data: () => ({
        key: 1,
        ownership: false,
        loaded: true,
        mode: "view",
        snackbar: false,
        chartId: null,
        chartType: undefined,
        chartData: {}
    }),
    computed: {
        currentUser() {
            return this.$store.state.user.user;
        }
    },
    methods: {
        forceRender() {
            this.key++;
        },
        btnfunc() {
            this.forceRender();
        },
        reloadChart() {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 500);
        },
        back(id) {
            // this.loaded = false;
            setTimeout(() => {
                this.$router.push({
                    name: "chartCollection",
                    params: { collection: id }
                });
            }, 200);
        },
        getChart() {
            let id = this.$route.params.id;
            this.chartId = Number.parseInt(id, 10);
            axios
                .get("chart/" + id)
                .then(response => {
                    this.chartData = response.data;
                    this.chartType = response.data.type;
                    this.bus.$emit("chartData", response.data);
                    this.forceRender();
                    this.loaded = true;
                })
                .catch(e => {
                    if (e.response.status == 404) {
                        this.$refs.alert
                            .open(
                                "Chart Not Found",
                                "This Is Not the Chart You Are Looking For",
                                {
                                    color: "danger"
                                }
                            )
                            .then(() => {
                                this.back(this.$route.params.collection);
                            });
                    }
                });
        },
        deleteChart() {
            this.$refs.confirm
                .open("Delete Chart", "Are you sure?", { color: "danger" })
                .then(delc => {
                    if (delc) {
                        axios
                            .delete("chart/" + this.chart.id)
                            .then(response => {
                                let res = JSON.parse(response.request.response);
                                this.$refs.alert
                                    .open("Success", res["message"], {
                                        color: "success"
                                    })
                                    .then(res => {
                                        this.loaded = false;
                                        this.bus.$emit("reloadCollection");
                                        this.back(
                                            this.$route.params.collection
                                        );
                                    });
                            })
                            .catch(res => {
                                let error = JSON.parse(res.request.response);
                                this.$refs.alert.open("Error", error["error"], {
                                    color: "danger"
                                });
                            });
                    }
                });
        }
    },
    created() {
        this.loaded = false;
        this.getChart();
        // this.loaded = true;
        // this.reloadChart();
        // this.loaded = false;
        // let id = this.$route.params.id;
        // try {
        //     let chart = await axios.get("chart/" + id);
        //     this.chart = chart.data;
        //     this.bus.$emit("setChartType", this.chart.type);
        //     this.loaded = true;
        // } catch (e) {
        //     if (e.response.status == 404) {
        //         this.$refs.alert
        //             .open(
        //                 "Chart Not Found",
        //                 "This Is Not the Chart You Are Looking For",
        //                 {
        //                     color: "danger"
        //                 }
        //             )
        //             .then(() => {
        //                 this.back(this.$route.params.collection);
        //             });
        //         // this.back(this.$route.params.collection);
        //     }
        //     console.error(e);
        // }
    },
    mounted() {
        this.bus.$on("saveChart", this.getChart);
    }
};
</script>
<style scoped>
.btn-sys-bar {
    cursor: pointer;
}
.theme--dark .btn-sys-bar:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
.theme--light .btn-sys-bar:hover {
    background-color: rgba(0, 0, 0, 0.2);
}
</style>
