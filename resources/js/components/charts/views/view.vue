<template>
    <v-main>
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>

        <v-toolbar class="mb-3" rounded elevation="2" dense>
            <v-btn icon @click="back(1)">
                <v-icon>
                    mdi-chevron-left
                </v-icon>
            </v-btn>
            <v-toolbar-title v-if="false">{{ chart.title }}</v-toolbar-title>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn icon @click="back(1)">
                <v-icon>
                    mdi-delete
                </v-icon>
            </v-btn>
            <v-btn icon @click="back(1)">
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
        <v-container v-if="loaded" fluid class="pa-0">
            <v-card elevation="2">
                <v-row>
                    <v-col cols="12" md="4" order="1" order-md="0">
                        <v-card-title> {{ chart.title }} </v-card-title>
                        <v-card-text> {{ chart.info }} </v-card-text>
                    </v-col>
                    <v-col cols="12" md="8" order="0" order-md="1">
                        <view-chart :mode="mode" :chart="chart"></view-chart>
                    </v-col>
                </v-row>
            </v-card>
        </v-container>

        <v-snackbar left :timeout="-1" v-model="snackbar">
            <div>
                <div class="ma-2">
                    <strong>Author:</strong> {{ chart.user_name }}
                </div>
                <v-divider></v-divider>
                <div class="ma-2">
                    <strong>Created at:</strong> {{ chart.created }}
                </div>
                <div class="ma-2">
                    <strong>Last Update:</strong> {{ chart.updated }}
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
    components: {
        viewChart,
        confirm,
        alert
    },
    data: () => ({
        copt: false,
        loaded: false,
        mode: "view",
        snackbar: false,
        chart: {}
    }),
    methods: {
        back(id) {
            // this.loaded = false;
            setTimeout(() => {
                this.$router.push({
                    name: "chartCollection",
                    params: { id: id }
                });
            }, 200);
        },
        editChart() {
            this.$router.push({
                name: this.chart.type + "Update",
                params: { id: this.$route.params.id }
            });
        },
        deleteChart() {
            this.$refs.confirm
                .open("Delete Chart", "Are you sure?", { color: "danger" })
                .then(delc => {
                    if (delc) {
                        axios
                            .delete("chart/" + this.$route.params.id)
                            .then(response => {
                                let res = JSON.parse(response.request.response);
                                this.$refs.alert
                                    .open("Success", res["message"], {
                                        color: "success"
                                    })
                                    .then(res => {
                                        this.loaded = false;
                                        this.$emit("closechart", "deleted");
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
    async created() {
        this.loaded = false;

        let id = this.$route.params.id;

        try {
            let chart = await axios.get("chart/" + id);
            this.chart = chart.data;

            if (!chart.data) {
                this.norecords = true;
            }

            console.log(chart.data);

            this.loaded = true;
        } catch (e) {
            console.error(e);
        }
    }
};
</script>

<style></style>
