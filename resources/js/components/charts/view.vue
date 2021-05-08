<template>
    <div class="d-flex">
        <v-container fluid class="pa-5">
            <v-overlay :value="!loaded" opacity="1" color="background">
                <v-progress-circular :size="30" color="primary" indeterminate>
                </v-progress-circular>
            </v-overlay>

            <v-row class="align-stretch">
                <v-col cols="12" md="4" class="order-1 order-md-0">
                    <h3 class="text-center text-md-left mb-4">
                        {{ chart.title }}
                    </h3>
                    <p>{{ chart.info }}</p>
                </v-col>
                <v-col cols="12" md="8" class="order-0 order-md-1">
                    <view-chart :mode="mode" :chart="chart"></view-chart>
                </v-col>
            </v-row>
        </v-container>

        <!-- Speed Dial -->
        <v-speed-dial
            fixed
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
                @click="editChart()"
            >
                <v-icon>mdi-pencil</v-icon>
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
    computed: {
        currentUser: {
            get() {
                return this.$store.state.user.user;
            }
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

            this.loaded = true;
        } catch (e) {
            console.error(e);
        }
    }
};
</script>

<style></style>
