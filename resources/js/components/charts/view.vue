<template>
    <div class="d-flex">
        <v-container fluid class="pa-5">
            <v-overlay :value="!loaded" color="accent">
                <v-progress-circular :size="30" color="primary" indeterminate>
                </v-progress-circular>
            </v-overlay>

            <v-row class="align-stretch">
                <v-col cols="12" md="4">
                    <h3>{{ chart.title }}</h3>
                    <p>{{ chart.info }}</p>
                </v-col>
                <v-col cols="12" md="8">
                    <view-chart :mode="mode" :chart="chart"></view-chart>
                </v-col>
            </v-row>
        </v-container>

        <!-- Speed Dial -->
        <v-speed-dial
            bottom
            right
            absolute
            v-model="copt"
            direction="left"
            transition="fab-transition"
        >
            <template v-slot:activator>
                <v-btn v-model="copt" small fab>
                    <v-icon v-if="copt">
                        mdi-close
                    </v-icon>
                    <v-icon v-else>
                        mdi-gesture-tap
                    </v-icon>
                </v-btn>
            </template>
            <v-btn @click="snackbar = true" fab dark x-small color="primary">
                <v-icon>mdi-information-variant</v-icon>
            </v-btn>
            <v-btn fab dark x-small color="primary">
                <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn fab dark x-small color="primary">
                <v-icon>mdi-plus</v-icon>
            </v-btn>
            <v-btn fab dark x-small color="red">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </v-speed-dial>

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
    </div>
</template>

<script>
import viewChart from "./preview/chart";
export default {
    components: {
        viewChart
    },
    data: () => ({
        copt: false,
        loaded: false,
        mode: "view",
        snackbar: false,
        chart: {}
    }),
    async created() {
        this.loaded = false;

        let id = this.$route.params.id;

        try {
            let chart = await axios.get("/api/v1/chart/" + id);
            this.chart = chart.data;

            console.log(chart.data);

            // if (!chartList.data) {
            //     this.norecords = true;
            // }

            this.loaded = true;
        } catch (e) {
            console.error(e);
        }
    }
};
</script>

<style></style>
