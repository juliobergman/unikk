<template>
    <div class="d-flex">
        <v-container fluid class="pa-5">
            <v-overlay :value="!loaded" opacity="1" color="background">
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
            <v-btn
                v-if="currentUser.id == chart.user_id"
                fab
                dark
                x-small
                color="primary"
            >
                <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn fab dark x-small color="primary">
                <v-icon>mdi-plus</v-icon>
            </v-btn>
            <v-btn
                v-if="currentUser.id == chart.user_id"
                @click="deleteChart()"
                fab
                dark
                x-small
                color="danger"
            >
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
        <confirm ref="confirm"></confirm>
        <alert ref="alert"></alert>
    </div>
</template>

<script>
import viewChart from "./preview/chart";
import confirm from "../ui/confirm";
import alert from "../ui/alert";
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
        deleteChart() {
            this.$refs.confirm
                .open(
                    "Delete Chart",
                    "If you delete this chart, it'll be gone forever.\n Are you sure?",
                    { color: "danger" }
                )
                .then(delc => {
                    if (delc) {
                        axios
                            .delete("/api/v1/chart/" + this.$route.params.id)
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
    computed: {
        currentUser: {
            get() {
                return this.$store.state.currentUser.user;
            }
        }
    },
    async created() {
        this.loaded = false;

        let id = this.$route.params.id;

        try {
            let chart = await axios.get("/api/v1/chart/" + id);
            this.chart = chart.data;

            if (!chart.data) {
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
