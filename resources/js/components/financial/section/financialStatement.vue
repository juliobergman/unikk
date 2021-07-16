<template>
    <v-main>
        <report-toolbar
            :bus="bus"
            @periodChange="periodChange"
            @monthChange="monthChange"
            @quarterChange="quarterChange"
            @lvlChange="lvlChange"
        >
        </report-toolbar>
        <v-divider></v-divider>
        <!-- <fs-top-bar :bus="bus"></fs-top-bar> -->
        <!-- <fs-table :bus="bus"></fs-table> -->
        <statement
            v-for="idx in 1"
            :key="idx"
            :period="period"
            :month="month"
            :quarter="quarter"
            :lvl="lvl"
            :search="search"
            :bus="bus"
        ></statement>
    </v-main>
</template>
<script>
import reportToolbar from "../ui/reportToolbar";
import Statement from "./components/statement";
import fsTable from "./components/fsTable";
import fsTopBar from "./components/fsTopBar";
export default {
    components: {
        reportToolbar,
        Statement,
        fsTable,
        fsTopBar
    },
    props: ["bus"],
    methods: {
        periodChange($payload) {
            this.period = $payload;

            if ($payload == "monthly") {
                this.search = this.month;
            }
            if ($payload == "quarterly") {
                this.search = this.quarter;
            }
            if ($payload == "yearly") {
                this.search = "yearly";
            }
        },
        monthChange($payload) {
            this.month = $payload;
            this.periodChange(this.period);
        },
        quarterChange($payload) {
            this.quarter = $payload;
            this.periodChange(this.period);
        },
        lvlChange($payload) {
            this.lvl = $payload;
            this.periodChange(this.period);
        }
    },
    data: () => ({
        period: "yearly",
        month: "jan",
        quarter: "q1",
        lvl: "lvl1",
        search: "yearly",
        reports: [
            { id: 1, rep: 2 }
            // { id: 2, rep: 2 },
            // { id: 3, rep: 1 }
        ]
    }),
    created() {}
};
</script>

<style>
.v-data-table__wrapper table tbody tr td {
    white-space: nowrap;
}
</style>
