<template>
    <v-card flat class="mt-3 mb-5">
        <fs-toolbar
            :bus="bus"
            :year="year"
            :setreport="report"
            :index="index"
            @changeYear="changeYear"
            @changeReport="changeReport"
        >
        </fs-toolbar>
        <v-divider></v-divider>
        <fs-table
            :bus="bus"
            :search="search"
            :rid="report.id"
            :report="report"
            :lvl="lvl"
            :year="year"
            :period="period"
        ></fs-table>
    </v-card>
</template>

<script>
import fsToolbar from "./fsToolbar";
import fsTable from "./fsTable";
export default {
    props: ["bus", "period", "search", "lvl", "repdata", "index"],
    components: {
        fsToolbar,
        fsTable
    },
    data: () => ({
        year: 2021,
        report: []
    }),
    methods: {
        changeYear($payload) {
            this.year = $payload;
        },
        changeReport($payload) {
            this.report = $payload;
        }
    },
    created() {
        this.changeReport(this.repdata);
    }
};
</script>

<style></style>
