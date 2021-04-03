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
        <v-container v-if="loaded" class="d-flex flex-wrap">
            <!-- Main Body -->

            <v-card
                v-for="(chart, idx) in chartdata"
                :key="idx"
                :loading="loading"
                class="mx-auto my-12"
                style="max-width: 400px;"
            >
                <chart-canvas :chart="chart"></chart-canvas>
            </v-card>

            <!--  -->
        </v-container>
    </v-main>
</template>

<script>
import chartCanvas from "./preview/chart";

export default {
    components: {
        chartCanvas
    },
    data: () => ({
        loading: false,
        loaded: false,
        chartdata: null
    }),
    async mounted() {
        this.loaded = false;
        try {
            let chartList = await axios.get("/api/v1/chart/all");
            this.chartdata = chartList.data;
            this.loaded = true;
        } catch (e) {
            console.error(e);
        }
    }
};
</script>

<style></style>
