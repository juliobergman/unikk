<template>
    <v-main>
        <v-toolbar elevation="2" dense>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn right>
                Button
            </v-btn>
            <v-btn left>
                Button
                <v-icon class="ml-2">mdi-album</v-icon>
            </v-btn>
        </v-toolbar>
        <v-container fluid v-if="loaded">
            <!-- No Records Found -->

            <v-alert
                v-model="norecords"
                border="left"
                close-text="Close"
                color="info"
                outlined
                dismissible
                transition="scroll-y-reverse-transition"
            >
                No Records has been found...
            </v-alert>

            <!-- Main Body -->
            <v-row>
                <v-col
                    cols="12"
                    sm="4"
                    v-for="(chart, idx) in chartdata"
                    :key="idx"
                >
                    <v-hover v-slot:default="{ hover }">
                        <v-card
                            class="py-3 pr-1"
                            :elevation="hover ? 6 : 3"
                            @click="showChart(chart.id)"
                            rounded="sm"
                            :loading="loading"
                        >
                            <chart-canvas :chart="chart"></chart-canvas>

                            <v-card-title class="subtitle-1">
                                {{ chart.title }}
                            </v-card-title>
                        </v-card>
                    </v-hover>
                </v-col>
            </v-row>
            <!--  -->
            <v-dialog v-model="dialog" fullscreen hide-overlay>
                <v-card>
                    <v-toolbar dense dark color="primary">
                        <v-toolbar-title>Settings</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dense icon dark @click="dialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                </v-card>
            </v-dialog>
        </v-container>
    </v-main>
</template>

<script>
import chartCanvas from "./preview/chart";
import Chart from "./globalSettings";
export default {
    components: {
        chartCanvas
    },
    data: () => ({
        norecords: false,
        dialog: false,
        loading: false,
        loaded: false,
        chartdata: null
    }),
    methods: {
        showChart(id) {
            this.dialog = true;
            console.log("showChart");
            console.log(id);
        }
    },
    async mounted() {
        this.loaded = false;
        try {
            let chartList = await axios.get("/api/v1/chart/all");
            this.chartdata = chartList.data;

            if (!chartList.data) {
                this.norecords = true;
            }

            this.loaded = true;
        } catch (e) {
            console.error(e);
        }
    }
};
</script>

<style></style>
