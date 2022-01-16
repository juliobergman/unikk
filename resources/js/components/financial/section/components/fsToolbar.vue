<template>
    <div>
        <v-toolbar flat rounded dense class="v-toolbar__no_pad mb-2">
            <v-btn-toggle group dense text tile mandatory color="teal">
                <v-btn value="income">
                    Income
                </v-btn>

                <v-btn value="balance">
                    Balance
                </v-btn>

                <v-btn value="ratio">
                    Ratio
                </v-btn>
            </v-btn-toggle>

            <v-spacer></v-spacer>
        </v-toolbar>
        <v-toolbar flat rounded dense class="v-toolbar__no_pad mb-2">
            <v-btn-toggle group dense text tile mandatory>
                <v-btn value="actual">
                    <v-icon small class="mr-2" color="rgba(88, 149, 255, 0.9)">
                        mdi-circle
                    </v-icon>
                    Actual
                </v-btn>

                <v-btn value="forecast">
                    <v-icon small class="mr-2" color="rgba(88, 255, 177, 0.9)">
                        mdi-circle
                    </v-icon>
                    Forecast
                </v-btn>
            </v-btn-toggle>

            <v-spacer></v-spacer>
        </v-toolbar>
    </div>
</template>

<script>
import fsAddBtn from "./fsAddBtn";
import FsExchangeMenu from "./fsExchangeMenu.vue";
export default {
    components: { fsAddBtn, FsExchangeMenu },
    props: ["bus", "report", "period"],
    data: () => ({
        year: undefined,
        yearButtons: [],
        reportMenu: []
    }),
    computed: {
        reportData: {
            get() {
                return this.report;
            },
            set(val) {
                this.bus.$emit("report:update", val);
            }
        }
    },
    methods: {
        getReportMenu() {
            axios
                .post("report/all")
                .then(response => {
                    this.reportMenu = response.data;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        getYears() {
            axios
                .get("date/years")
                .then(response => {
                    this.yearButtons = response.data;
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        this.getReportMenu();
        this.getYears();
        this.year = this.period.year;
    }
};
</script>

<style></style>
